
<form class="row g-3 needs-validation" id="contact-form" novalidate>
    <div class="col-12 col-md-6 form-column">
        <input type="text" wire:model="voornaam_contact" class="form-control contact-form" placeholder="Voornaam *" id="validationCustom01" required>
    </div>

    <div class="col-12 col-md-6 form-column">

        <input type="text" wire:model="achternaam_contact" placeholder="Achternaam *" class="form-control contact-form" id="validationCustom02" required>

    </div>

    <div class="col-12 col-md-6 form-column">

        <input type="tel" wire:model="telefoonnummer_contact" placeholder="Telefoonnummer"  class="form-control contact-form" id="validationCustom03">

    </div>

    <div class="col-12 col-md-6 form-column">
        <input type="email" wire:model="email_contact" class="form-control contact-form" placeholder="E-mailadres *" id="validationCustom04" required>
    </div>

    <div class="col-12 col-md-12 form-column">
        <textarea wire:model="bericht_contact" class="form-control contact-form" placeholder="Bericht *" id="validationCustom05" required></textarea>
    </div>

    <div id="succes-alert" class="hidden contact-alert alert alert-success alert-warning alert-dismissible fade show" role="alert">
        Het contactformulier is succesvol verstuurd! Wij nemen zo snel mogelijk contact met u op.
        <button type="button" class="btn-close btn-close-alert-succes" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="col-12 form-column">
        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
        <span id="captcha-error" class="text-danger" style="display:none;">Je moet de captcha invullen</span>
    </div>

    <div class="col-12 form-column">
        <button type="submit" class="btn-primary btn magazine-btn" wire:click="storeContact">
            <i  wire:loading.class="d-inline-block" wire:target="storeContact" class="display-none fa fa-spinner fa-spin"></i> Verzenden</button>
            <input id="captcha" wire:model="captcha" class="display-none"/>
    </div>

</form>


<script src="https://www.google.com/recaptcha/api.js" async defer></script>


<script>



    function resetForm() {
        alert('reset');
        jQuery('#validationCustom01').val('');

    }

    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation');

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                event.preventDefault(); // voorkom standaard submit

                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return;
                }

                // Haal captcha token
                const captchaResponse = grecaptcha.getResponse();
                console.log('Captcha token:', captchaResponse);

                if (captchaResponse.length === 0) {
                    jQuery('#captcha-error').show();
                    form.classList.add('was-validated');
                    return;
                } else {
                    jQuery('#captcha-error').hide();
                }

                // Zet captcha token in hidden input voor Livewire
                const input = document.getElementById('captcha');
                if (input) {
                    input.value = captchaResponse;

                    // Trigger input event zodat Livewire property update
                    input.dispatchEvent(new Event('input', { bubbles: true }));
                }


                console.log('Form submitted via Livewire');

                // Reset frontend
                jQuery('.contact-alert').removeClass('hidden');
                form.classList.remove('was-validated');
                form.reset();
                grecaptcha.reset();
            });
        });
    })();



</script>
