
console.log('app.js');

document.addEventListener('DOMContentLoaded', () => {
  // csrf delete
  document.querySelectorAll('[data-delete]').forEach(el => {
    el.addEventListener('click', event => {
      event.preventDefault();
      fetch(el.getAttribute('href'), {
        method: 'DELETE',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          _token: el.dataset.token
        })
      }).then(res => res.json())
        .then(data => {
          if (!data.success){
            throw data.error || 'Erreur';
          }
          el.parentNode.parentNode.removeChild(el.parentNode);
        })
        .catch(error => alert(error))
    })
  });
});

