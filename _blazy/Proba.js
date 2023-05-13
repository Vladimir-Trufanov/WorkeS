// Код
var bLazy = new Blazy
({
  success: function()
  {
    updateCounter();
  }
});


// not needed, only here to illustrate amount of loaded images
var imageLoaded = 0;
var eleCountLoadedImages = document.getElementById('loaded-images');

function updateCounter() 
{
  imageLoaded++;
  eleCountLoadedImages.innerHTML = imageLoaded;
}
