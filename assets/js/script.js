document.addEventListener('DOMContentLoaded', () => {
  const phone = document.querySelector('input[name="phone"]');
  if (phone) {
    phone.addEventListener('input', () => {
      let digits = phone.value.replace(/\D/g, '').substring(0, 10);
      if (digits.length === 0) {
        phone.value = '';
        return;
      }
      let result = '+7(';
      if (digits.length >= 1) result += digits.substring(0, 3);
      if (digits.length >= 4) result += ')-' + digits.substring(3, 6);
      if (digits.length >= 7) result += '-' + digits.substring(6, 8);
      if (digits.length >= 9) result += '-' + digits.substring(8, 10);
      phone.value = result;
    });
  }
});
