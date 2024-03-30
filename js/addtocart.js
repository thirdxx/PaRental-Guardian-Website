function addToCart(button) {
  var icon = button.querySelector("i");

  // Toggle text and icon
  if (button.classList.contains("added-to-cart")) {
    button.innerHTML = "Add to cart <i class='fas fa-arrow-right'></i>";
    button.classList.remove("added-to-cart");
  } else {
    button.innerHTML = "Added to cart <i class='fas fa-check'></i>";
    button.classList.add("added-to-cart");
  }
}