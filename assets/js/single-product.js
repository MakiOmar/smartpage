// Find the "Load More Comments" anchor link.
var loadMoreLink = document.querySelector('.load-more-comments');

// Attach a click event listener to the anchor link.
loadMoreLink.addEventListener('click', function(event) {
    event.preventDefault();

    // Find the element with the class "current" within the "woocommerce-pagination" element
    var currentElement = document.querySelector('.woocommerce-pagination .current');
    //console.log(currentElement);
    // Check if the currentElement exists and has a previous sibling
    if (currentElement && currentElement.parentElement.previousElementSibling) {
        // Trigger a click event on the previous sibling element
        var prevElement = currentElement.parentElement.previousElementSibling;
        prevElement.querySelector('.page-numbers').click();
    } else {
        loadMoreLink.style.visibility = "hidden";
    }
});


// Find the element with the class "current" within the "woocommerce-pagination" element
var currentElement = document.querySelector('.woocommerce-pagination .current');
// Check if the currentElement exists and has a no previous sibling
if ( currentElement && null === currentElement.parentElement.previousElementSibling ) {
    loadMoreLink.style.visibility = "hidden";
}