// Sample cart data
const cart = [
  { id: 1, name: 'Product 1', quantity: 2, price: 10.0 },
  { id: 2, name: 'Product 2', quantity: 1, price: 20.0 },
  { id: 3, name: 'Product 3', quantity: 3, price: 5.0 }
];

function viewCart() {
  // Get the modal
  const modal = document.getElementById('cartModal');
  const cartItemsList = document.getElementById('cartItems');

  // Clear previous cart items
  cartItemsList.innerHTML = '';

  // Populate the cart items
  cart.forEach(item => {
      const listItem = document.createElement('li');
      listItem.textContent = `${item.name} - Quantity: ${item.quantity} - Price: $${item.price}`;
      cartItemsList.appendChild(listItem);
  });

  // Display the modal
  modal.style.display = 'block';
}

// Get the <span> element that closes the modal
const closeModal = document.getElementById('closeCart');

// When the user clicks on <span> (x), close the modal
closeModal.onclick = function() {
  document.getElementById('cartModal').style.display = 'none';
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  const modal = document.getElementById('cartModal');
  if (event.target == modal) {
      modal.style.display = 'none';
  }
}
