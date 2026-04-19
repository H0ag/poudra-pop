// Unique key for Poudra-Pop storage
const POUDRA_CART_KEY = 'poudra_pop_cart';

function getRawCart() {
    try {
        const cartString = localStorage.getItem(POUDRA_CART_KEY);
        return cartString ? JSON.parse(cartString) : [];
    } catch (e) {
        console.error("Error reading Poudra-Pop localStorage", e);
        return [];
    }
}

function saveRawCart(cartArray) {
    localStorage.setItem(POUDRA_CART_KEY, JSON.stringify(cartArray));
    $(window).trigger('cartUpdated');
}

// Add an item
function addToCart(articleRef, quantity = 1) {
    let cart = getRawCart();
    
    const existingItem = $.grep(cart, function(item) {
        return item.ref === articleRef;
    })[0];
    
    if (existingItem) {
        existingItem.qty += quantity;
    } else {
        cart.push({ ref: articleRef, qty: quantity });
    }
    
    saveRawCart(cart);
}

function removeFromCart(articleRef) {
    let cart = getRawCart();
    cart = $.grep(cart, function(item) {
        return item.ref !== articleRef;
    });
    saveRawCart(cart);
}

// --- INIT ---
$(document).ready(function() {
    if (!localStorage.getItem(POUDRA_CART_KEY)) {
        saveRawCart([]);
    }
});


/**
 * Updates the cart badge count in the navigation bar
 */
function updateCartBadge() {
    const cart = getRawCart();
    
    // Sum all quantities
    const totalQty = cart.reduce((total, item) => {
        return total + item.qty;
    }, 0);

    const $badge = $('#poudra-cart-count');

    if (totalQty > 0) {
        $badge.text(`(${totalQty})`);
    } else {
        $badge.text('');
    }
}

// Initial call when the document is ready
$(document).ready(function() {
    updateCartBadge();
});