<section class="py-5 bg-body-tertiary">
    <div class="container">
        <h1 class="display-5 fw-semibold mb-4">Checkout</h1>
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Billing details</h2>
                        <form class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First name</label>
                                <input type="text" class="form-control" placeholder="Jane">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last name</label>
                                <input type="text" class="form-control" placeholder="Doe">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="jane@example.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Company</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" rows="3" placeholder="Tell us about your goals"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h2 class="h5">Order summary</h2>
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex justify-content-between">Strategic Advisory Package <span>$2,499.00</span></li>
                            <li class="list-group-item d-flex justify-content-between">Implementation Sprint <span>$1,299.00</span></li>
                        </ul>
                        <div class="d-flex justify-content-between fw-semibold fs-5 mb-3">
                            <span>Total</span>
                            <span>$3,798.00</span>
                        </div>
                        <div class="d-grid gap-3">
                            <button class="btn btn-primary btn-lg" type="button">Pay with Stripe Checkout</button>
                            <div id="paypal-button-container"></div>
                        </div>
                        <p class="small text-muted mt-3">Demo integrations use sandbox credentials. Configure Stripe and PayPal keys in the admin settings to enable live payments.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://www.paypal.com/sdk/js?client-id=<?php echo e(PAYPAL_CLIENT_ID); ?>&currency=USD" defer></script>
<script src="js/checkout.js" defer></script>
