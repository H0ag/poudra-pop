/**
 * Orchestrates the cart rendering process using jQuery
 */
function initCartPage() {
    const cart = getRawCart();
    
    if (cart.length === 0) {
        $('#poudra-cart-wrapper').hide();
        $('#cart-empty-message').show();
        return;
    }

    $.ajax({
        url: '/user/getcart',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(cart),
        dataType: 'json',
        success: function(data) {
            if (data.success) {
                renderCartTable(data.items, data.grand_total);
            } else {
                console.error('Error:', data.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Fetch error:', error);
        }
    });
}

/**
 * The actual rendering function using jQuery
 */
function renderCartTable(items, total) {
    const $tbody = $('#cart-items-body');
    const $totalDisplay = $('#cart-grand-total');
    
    let rows = '';
    
    $.each(items, function(index, item) {
        rows += `
            <tr class="cart-item">
                <td class="col-product">
                    <div class="product-info">
                        <img src="/item/thumbnail/${item.item_id}/0?size=62" class="product-thumb">
                        <div class="product-details">
                            <a class="product-name" href="/item/${item.ref}">${item.name}</a>
                            <span class="product-ref">REF: ${item.ref}</span>
                        </div>
                    </div>
                </td>
                <td class="col-price">${item.valid_price} €</td>
                <td class="col-qty">
                    <input type="number" value="${item.qty}" min="1" class="qty-input" data-ref="${item.ref}" disabled>
                </td>
                <td class="col-subtotal">${item.item_total} €</td>
            </tr>
        `;
    });

    // Update the DOM
    $tbody.html(rows);
    $totalDisplay.text(total + ' €');
}

// Initial call when the document is ready
$(document).ready(function() {
    initCartPage();
});