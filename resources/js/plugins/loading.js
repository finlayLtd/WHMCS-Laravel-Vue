// loading.js
function showLoader(value) {
  if (value) {
    const loadingDiv = document.createElement('div');
    loadingDiv.id = 'loading-bg';
    loadingDiv.style.display = 'block';
    loadingDiv.style.zIndex = '9999';
    loadingDiv.innerHTML = `
      <div class="loading_new" style="margin: auto;">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <div class="text-center" style="position: absolute; top: 82px;">Loading Please wait</div>
      </div>
    `;
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
    const mainContent = document.getElementById('app');
    if (mainContent) {
      mainContent.insertBefore(loadingDiv, mainContent.firstChild);
    } else {
      console.error('Element with ID "app" not found.');
    }
  } else {
    const loadingDiv = document.getElementById('loading-bg');
    if (loadingDiv) {
      loadingDiv.parentNode.removeChild(loadingDiv);
    }
  }
}


export { showLoader };
