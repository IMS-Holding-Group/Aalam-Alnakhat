document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.querySelector('#search');
  const filterSelect = document.querySelector('#filter');
  const dishCards = document.querySelectorAll('.dish-card');
  
  if (searchInput) {
    searchInput.addEventListener('keyup', function() {
      const searchValue = this.value.toLowerCase();
      const filterValue = filterSelect ? filterSelect.value : '';
      
      dishCards.forEach(card => {
        const name = card.querySelector('.dish-name').textContent.toLowerCase();
        const type = card.querySelector('.dish-type').textContent;
        const matchesSearch = name.includes(searchValue);
        const matchesFilter = !filterValue || type === filterValue;
        
        if (matchesSearch && matchesFilter) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    });
  }
  
  if (filterSelect) {
    filterSelect.addEventListener('change', function() {
      const filterValue = this.value;
      const searchValue = searchInput ? searchInput.value.toLowerCase() : '';
      
      dishCards.forEach(card => {
        const name = card.querySelector('.dish-name').textContent.toLowerCase();
        const type = card.querySelector('.dish-type').textContent;
        const matchesSearch = name.includes(searchValue);
        const matchesFilter = !filterValue || type === filterValue;
        
        if (matchesSearch && matchesFilter) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    });
  }
});

