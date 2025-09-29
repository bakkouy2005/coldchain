document.addEventListener('DOMContentLoaded', function () {
  var textareas = [];
  var sollicitatie = document.querySelectorAll('#sollicitatie-form textarea');
  var offerte = document.querySelectorAll('#offerte-form textarea');
  sollicitatie.forEach(function (el) { textareas.push(el); });
  offerte.forEach(function (el) { textareas.push(el); });

  var maxChars = 200;

  function createCounterElement(currentLength) {
    var counter = document.createElement('div');
    counter.className = 'text-gray-400 text-sm mt-1';
    counter.textContent = currentLength + '/' + maxChars;
    return counter;
  }

  function ensureCounter(textarea) {
    var next = textarea.nextElementSibling;
    if (next && next.dataset && next.dataset.counter === 'true') {
      return next;
    }
    var counter = createCounterElement(textarea.value.length);
    counter.dataset.counter = 'true';
    textarea.parentNode.insertBefore(counter, textarea.nextSibling);
    return counter;
  }

  textareas.forEach(function (ta) {
    ta.setAttribute('maxlength', String(maxChars));
    var counter = ensureCounter(ta);

    function updateCounter() {
      if (ta.value.length > maxChars) {
        ta.value = ta.value.slice(0, maxChars);
      }
      counter.textContent = ta.value.length + '/' + maxChars;
    }

    ta.addEventListener('input', updateCounter);
    ta.addEventListener('change', updateCounter);
    updateCounter();
  });
});


