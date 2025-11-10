<?php
namespace PHPMailer\PHPMailer;

class PHPMailer
{
    public bool $SMTPAuth = true;
    public string $Host = '';
    public int $Port = 587;
    public string $Username = '';
    public string $Password = '';
    public string $SMTPSecure = 'tls';
    public string $CharSet = 'UTF-8';
    private bool $smtp = false;
    private string $fromEmail = '';
    private string $fromName = '';
    private array $addresses = [];
    public string $Subject = '';
    public string $Body = '';
    private bool $isHtml = false;

    public function __construct(private bool $exceptions = false)
    {
    }

    public function isSMTP(): void
    {
        $this->smtp = true;
    }

    public function setFrom(string $address, string $name = ''): void
    {
        $this->fromEmail = $address;
        $this->fromName = $name;
    }

    public function addAddress(string $address, string $name = ''): void
    {
        $this->addresses[] = [$address, $name];
    }

    public function isHTML(bool $isHtml = true): void
    {
        $this->isHtml = $isHtml;
    }

    public function send(): bool
    {
        if ($this->smtp) {
            return $this->sendSMTP();
        }
        $headers = [];
        $headers[] = 'From: ' . ($this->fromName ? "$this->fromName <{$this->fromEmail}>" : $this->fromEmail);
        if ($this->isHtml) {
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=' . $this->CharSet;
        }
        $to = implode(',', array_map(fn($addr) => $addr[1] ? "{$addr[1]} <{$addr[0]}>" : $addr[0], $this->addresses));
        return mail($to, $this->Subject, $this->Body, implode("\r\n", $headers));
    }

    private function sendSMTP(): bool
    {
        $transport = ($this->SMTPSecure === 'ssl' ? 'ssl://' : '') . $this->Host;
        $port = $this->Port ?: ($this->SMTPSecure === 'ssl' ? 465 : 587);
        $connection = @stream_socket_client($transport . ':' . $port, $errno, $errstr, 10, STREAM_CLIENT_CONNECT, stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]));
        if (!$connection) {
            if ($this->exceptions) {
                throw new Exception('No se pudo conectar al servidor SMTP: ' . $errstr);
            }
            return false;
        }
        stream_set_timeout($connection, 10);
        $this->read($connection);
        $this->command($connection, 'EHLO ' . gethostname());
        if ($this->SMTPSecure === 'tls') {
            $this->command($connection, 'STARTTLS');
            stream_socket_enable_crypto($connection, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
            $this->command($connection, 'EHLO ' . gethostname());
        }
        if ($this->SMTPAuth) {
            $this->command($connection, 'AUTH LOGIN');
            $this->command($connection, base64_encode($this->Username));
            $this->command($connection, base64_encode($this->Password));
        }
        $this->command($connection, 'MAIL FROM: <' . $this->fromEmail . '>');
        foreach ($this->addresses as $addr) {
            $this->command($connection, 'RCPT TO: <' . $addr[0] . '>');
        }
        $this->command($connection, 'DATA');
        $headers = [];
        $headers[] = 'From: ' . ($this->fromName ? "$this->fromName <{$this->fromEmail}>" : $this->fromEmail);
        $headers[] = 'To: ' . implode(',', array_map(fn($addr) => $addr[1] ? "{$addr[1]} <{$addr[0]}>" : $addr[0], $this->addresses));
        $headers[] = 'Subject: ' . $this->Subject;
        $headers[] = 'MIME-Version: 1.0';
        if ($this->isHtml) {
            $headers[] = 'Content-Type: text/html; charset=' . $this->CharSet;
        } else {
            $headers[] = 'Content-Type: text/plain; charset=' . $this->CharSet;
        }
        $message = implode("\r\n", $headers) . "\r\n\r\n" . $this->Body . "\r\n.";
        fwrite($connection, $message . "\r\n");
        $this->read($connection);
        $this->command($connection, 'QUIT');
        fclose($connection);
        return true;
    }

    private function command($connection, string $command): void
    {
        fwrite($connection, $command . "\r\n");
        $this->read($connection);
    }

    private function read($connection): void
    {
        $response = '';
        while ($line = fgets($connection, 515)) {
            $response .= $line;
            if (isset($line[3]) && $line[3] === ' ') {
                break;
            }
        }
        if (!preg_match('/^[23]/', $response)) {
            if ($this->exceptions) {
                throw new Exception('Error SMTP: ' . $response);
            }
        }
    }
}
