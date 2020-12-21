function convertToRupiah(angka)
{
	var rupiah = '';
	var angkarev = angka.toString().split('').reverse().join('');
	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
	return rupiah.split('',rupiah.length-1).reverse().join('');
}
// function convertToRupiah(angka) {
//     separator = ".";
//     a = angka.value;
//     b = a.replace(/[^\d]/g,"");
//     c = "";
//     panjang = b.length;
//     j = 0;
//     for (i = panjang; i > 0; i--) {
//       j = j + 1;
//       if (((j % 3) == 1) && (j != 1)) {
//         c = b.substr(i-1,1) + separator + c;
//       } else {
//         c = b.substr(i-1,1) + c;
//       }
//     }
//     angka.value = 'Rp. '+ c;
// }

/**
 * Usage example:
 * alert(convertToRupiah(10000000)); -> "Rp. 10.000.000"
 */

function convertToAngka(rupiah)
{
	return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
}
/**
 * Usage example:
 * alert(convertToAngka("Rp 10.000.123")); -> 10000123
 */
