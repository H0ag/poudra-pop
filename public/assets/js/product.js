/**
 * Updates the UI of the buttons based on whether the item is in the cart
 * @param {string} ref 
 */
function updateButtonUI(ref) {
    const cart = getRawCart();
    // Use $.grep or some() to check existence
    const isInCart = cart.some(item => item.ref === ref);
    const $buttons = $(`.poudra-cart-action-btn[data-ref="${ref}"]`);

    $buttons.each(function() {
        const $btn = $(this);
        if (isInCart) {
            $btn.text("SUPPRIMER DU PANIER")
                .addClass('btn-remove')
                .removeClass('btn-add');
        } else {
            $btn.text("AJOUTER AU PANIER")
                .addClass('btn-add')
                .removeClass('btn-remove');
        }
    });
}

$(document).on('click', '.poudra-cart-action-btn', function(event) {
    const $btn = $(this);
    const ref = $btn.attr('data-ref');
    const $container = $btn.closest('.purchase-zone');
    const $qtyInput = $container.find('.poudra-qty-input');
    const quantity = parseInt($qtyInput.val()) || 1;

    const cart = getRawCart();
    const isInCart = cart.some(item => item.ref === ref);

    if (isInCart) {
        removeFromCart(ref);
        console.log(`${ref} removed from sachet.`);
        alert(`${ref} removed from sachet.`);
    } else {
        addToCart(ref, quantity);
        console.log(`${ref} added with quantity: ${quantity}`);
        alert(`${ref} added with quantity: ${quantity}`);
    }

    updateButtonUI(ref);
});

// Initial UI sync on page load
$(document).ready(function() {
    $('.poudra-cart-action-btn').each(function() {
        updateButtonUI($(this).attr('data-ref'));
    });
});