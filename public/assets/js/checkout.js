$(document).ready(function() {
    // Configuration mapping inputs to card elements and their masks
    const cardMappings = [
        { 
            input: '#input-holder', 
            display: '.card-holder', 
            mask: 'xxxxxxxx',
            type: 'text'
        },
        { 
            input: '#input-number', 
            display: '.card-number', 
            mask: 'xxxx xxxx xxxx xxxx',
            type: 'number'
        },
        { 
            input: '#input-expiry', 
            display: '.card-valid', 
            mask: 'xx/xx',
            type: 'expiry'
        },
        { 
            input: '#input-cvc', 
            display: '.card-seccode', 
            mask: 'xxx',
            type: 'cvc'
        }
    ];

    // Initialize listeners for each mapping
    cardMappings.forEach(config => {
        $(config.input).on('input', function() {
            let value = $(this).val();

            // 1. Formatting logic based on field type
            if (config.type === 'number') {
                // Remove all non-digits, limit to 16, add space every 4 digits
                value = value.replace(/\D/g, '').substring(0, 16);
                value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
                $(this).val(value);
            } 
            else if (config.type === 'expiry') {
                // Remove all non-digits, limit to 4, add slash after 2 digits
                value = value.replace(/\D/g, '').substring(0, 4);
                if (value.length > 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2);
                }
                $(this).val(value);
            }
            else if (config.type === 'cvc') {
                value = value.replace(/\D/g, '').substring(0, 3);
                $(this).val(value);
            }

            // 2. Masking logic (Keeping 'x' for empty slots)
            let displayValue = "";
            let currentVal = $(this).val();
            
            // Iterate through the mask to fill it with user input or 'x'
            for (let i = 0; i < config.mask.length; i++) {
                if (currentVal[i]) {
                    displayValue += currentVal[i];
                } else {
                    displayValue += config.mask[i];
                }
            }

            // 3. Update the card display
            $(config.display).text(displayValue);
        });
    });

    /**
     * Handles the final checkout submission
     */
    $('#payment-form').on('submit', function(e) {
        e.preventDefault();
        
        const $btn = $('.btn-validate');
        const originalText = $btn.text();
        $btn.prop('disabled', true).text('PROCESSING SHIPMENT...');

        const cart = getRawCart();
        
        // Build the payload
        const orderData = {
            shipping: {
                full_name: $('#input-holder').val(),
                address: $('#shipping-address').val(),
                city: $('#shipping-city').val(),
                zip: $('#shipping-zip').val(),
                phone: null
            },
            cart: cart,
            payment_method: 'Credit Card'
        };

        $.ajax({
            url: '/checkout/process', 
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(orderData),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    localStorage.removeItem('poudra_pop_cart');
                    window.location.href = '/dashboard?order_success=true';
                } else {
                    alert("Erreur d'usine: " + response.message);
                    $btn.prop('disabled', false).text(originalText);
                }
            },
            error: function() {
                alert('Jcrois que la machine est cassée. Veuillez réessayer plus tard.');
                $btn.prop('disabled', false).text(originalText);
            }
        });
    });
});