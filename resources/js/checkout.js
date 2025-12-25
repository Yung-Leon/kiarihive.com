document.addEventListener("DOMContentLoaded", () => {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartItemsList = document.getElementById("checkout-cart-items");
    const totalEl = document.getElementById("checkout-total");

    function renderCart() {
        cartItemsList.innerHTML = "";
        let total = 0;
        cart.forEach((item, index) => {
            const li = document.createElement("li");
            li.className = "list-group-item d-flex justify-content-between align-items-center";
            li.innerHTML = `
                <div>
                    ${item.name} 
                    <button class="btn btn-sm btn-secondary ms-2" onclick="changeQty(${index},-1)">-</button>
                    <button class="btn btn-sm btn-secondary ms-1" onclick="changeQty(${index},1)">+</button>
                    <button class="btn btn-sm btn-danger ms-1" onclick="removeItem(${index})">x</button>
                </div>
                <span>KES ${item.price * item.qty}</span>
            `;
            cartItemsList.appendChild(li);
            total += item.price * item.qty;
        });
        totalEl.textContent = total.toLocaleString();
        localStorage.setItem("cart", JSON.stringify(cart));
    }

    window.changeQty = function(index, delta) {
        cart[index].qty += delta;
        if(cart[index].qty <= 0) cart.splice(index,1);
        renderCart();
    }

    window.removeItem = function(index) {
        cart.splice(index,1);
        renderCart();
    }

    renderCart();

    document.getElementById("checkoutForm").onsubmit = e => {
        e.preventDefault();
        if(cart.length === 0){
            alert("Your cart is empty!");
            return;
        }

        const formData = new URLSearchParams({
            name: e.target.name.value,
            email: e.target.email.value,
            address: e.target.address.value,
            cart: JSON.stringify(cart)
        });

        fetch("includes/checkout.php", {
            method: "POST",
            headers: {"Content-Type":"application/x-www-form-urlencoded"},
            body: formData
        })
        .then(res => res.text())
        .then(()=>{
            alert("Order placed successfully!");
            localStorage.removeItem("cart");
            window.location.href = "index.php";
        })
        .catch(()=>{
            alert("Failed to place order. Try again.");
        });
    };
});
