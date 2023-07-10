document.getElementById('package').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const price = selectedOption.dataset.price;
    const discount = selectedOption.dataset.discount;
    const totalDiscount = price * (discount / 100);
    document.querySelector('[name=price]').value = price;
    document.querySelector('[name=discount]').value = totalDiscount;
});