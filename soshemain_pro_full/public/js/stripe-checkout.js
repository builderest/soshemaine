(async function initiateStripeCheckout() {
    if (!window.Stripe) {
        console.warn('Stripe.js not loaded');
        return;
    }
    const stripeKey = window.STRIPE_PUBLISHABLE_KEY || 'pk_test_placeholder';
    const stripe = Stripe(stripeKey);
    try {
        const response = await fetch('/api/create-checkout-session.php', { method: 'POST' });
        const data = await response.json();
        if (!data.id) {
            throw new Error('Invalid session response');
        }
        await stripe.redirectToCheckout({ sessionId: data.id });
    } catch (error) {
        console.error(error);
        window.location.href = '/order-failed.php';
    }
})();
