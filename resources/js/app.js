// Load Products
function loadProducts() {
  fetch("includes/products.php")
    .then(res => res.json())
    .then(products => {
      const container = document.getElementById("products-container");
      container.innerHTML = "";
      products.forEach(p => {
        container.innerHTML += `
          <div class="col-md-4">
            <div class="card">
              <img src="${p.image}" class="card-img-top" alt="${p.name}">
              <div class="card-body text-center">
                <h5>${p.name}</h5>
                <p class="text-muted">${p.description}</p>
                <strong>KES ${Number(p.price).toLocaleString()}</strong><br>
                <button class="btn btn-honey mt-2" onclick='addToCart(${JSON.stringify(p)})'>Add to Cart</button>
              </div>
            </div>
          </div>
        `;
      });
    }).catch(err => console.error("Failed to load products:", err));
}

// Load Cart
function loadCart() {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  const cartItemsDropdown = document.getElementById("cart-items-dropdown");
  const cartTotalDropdown = document.getElementById("cart-total-dropdown");
  const cartCount = document.getElementById("cart-count");

  cartItemsDropdown.innerHTML = "";
  let total = 0;
  cart.forEach((item, index) => {
    const div = document.createElement("div");
    div.classList.add("d-flex","justify-content-between","align-items-center","mb-2");
    div.innerHTML = `
      <span>${item.name} x${item.qty}</span>
      <div>
        <button class="btn btn-sm btn-secondary me-1" onclick="changeQty(${index},-1)">-</button>
        <button class="btn btn-sm btn-secondary me-1" onclick="changeQty(${index},1)">+</button>
        <button class="btn btn-sm btn-danger" onclick="removeItem(${index})">x</button>
        <span>KES ${item.price * item.qty}</span>
      </div>
    `;
    cartItemsDropdown.appendChild(div);
    total += item.price * item.qty;
  });

  cartTotalDropdown.textContent = `KES ${total.toLocaleString()}`;
  cartCount.textContent = cart.reduce((a,b)=>a+b.qty,0);
}

// Add to Cart
function addToCart(product) {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  const existing = cart.find(i => i.id == product.id);
  if(existing) existing.qty++;
  else cart.push({...product, qty:1});
  localStorage.setItem("cart", JSON.stringify(cart));
  loadCart();
}

// Change quantity
function changeQty(index, delta) {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  cart[index].qty += delta;
  if(cart[index].qty <= 0) cart.splice(index,1);
  localStorage.setItem("cart", JSON.stringify(cart));
  loadCart();
}

// Remove item
function removeItem(index) {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  cart.splice(index,1);
  localStorage.setItem("cart", JSON.stringify(cart));
  loadCart();
}

// Checkout Button Redirect
document.addEventListener("DOMContentLoaded", ()=>{
  loadProducts();
  loadCart();
  document.getElementById("checkout-btn-dropdown").addEventListener("click", ()=>{
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    if(cart.length === 0){ alert("Your cart is empty!"); return; }
    window.location.href = "checkout.php";
  });

  document.getElementById("newsletterForm").addEventListener("submit", function(e){
    e.preventDefault();
    alert("Thank you for subscribing to KiariHive!");
    this.reset();
  });
});
