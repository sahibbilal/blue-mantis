function scrollUp(value, instanceIndex = 0) {
  let position = value ? value : 0;
  const mainHeader = document.querySelector('.main-header');

  if (0 === position) {
    let postContainer = document.querySelectorAll('.eight29-filters');

    if (postContainer.length && postContainer[instanceIndex]) {
      let rect = postContainer[instanceIndex].getBoundingClientRect();
      position = rect.top + window.pageYOffset;
    }

    if (null !== mainHeader) {
      position = position - mainHeader.offsetHeight - 16;
    }
  }

  window.scrollTo({
    top: position,
    left: 0,
    behavior: 'smooth'
  });
}

export default scrollUp;