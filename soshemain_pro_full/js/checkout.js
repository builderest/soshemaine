window.addEventListener('DOMContentLoaded', () => {
  const stripeButton = document.querySelector('.btn.btn-primary.btn-lg');
  if (stripeButton) {
    stripeButton.addEventListener('click', () => {
      alert('Stripe Checkout demo: configure STRIPE_PUBLISHABLE_KEY in admin settings to go live.');
    });
  }
  if (window.paypal && document.getElementById('paypal-button-container')) {
    paypal.Buttons({
      style: { layout: 'horizontal' },
      createOrder: (data, actions) => actions.order.create({ purchase_units: [{ amount: { value: '3798.00' } }] }),
      onApprove: () => alert('PayPal demo payment approved!'),
    }).render('#paypal-button-container');
  }
});
