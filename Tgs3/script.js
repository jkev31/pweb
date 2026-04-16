function hitung(op) {
    let a = parseInt(document.getElementById("angka1").value);
    let b = parseInt(document.getElementById("angka2").value);
    let hasil;

    switch (op) {
        case "+": hasil = a + b; break;
        case "-": hasil = a - b; break;
        case "*": hasil = a * b; break;
        case "/": hasil = b !== 0 ? a / b : "Error"; break;
    }

    document.getElementById("display").value =
        a + " " + op + " " + b + " = " + hasil;
}


/* perbedaan == dan === terletak pada fungsi perbandingannya
   == digunakan untuk membandingkan nilai 
   === digunakan untuk membandingkan nilai dan tipe data
*/



function verifyUser() {
    let nama = prompt("Enter your username");
    if (nama) {
        alert("Hello " + nama);
        document.getElementById("hello").innerHTML = "Hello, " + nama + "!";
        document.getElementById("Paragraph").innerHTML += "Welcome to your all-in-one calculator, thoughtfully designed to make everyday calculations simple, fast, and dependable. Whether you’re working out basic arithmetic, managing personal finances, calculating percentages, or solving more detailed numerical problems, this tool is here to support you every step of the way. Its clean and intuitive interface ensures that you can focus entirely on your calculations without unnecessary distractions or confusion. This calculator is built for everyone, from students and professionals to anyone who needs quick and accurate results on the go. With responsive performance and user-friendly controls, you can carry out tasks efficiently, saving both time and effort. Whether you’re double-checking figures, planning a budget, or completing assignments, you’ll find this tool reliable and easy to use. In addition to its simplicity, the calculator is designed to provide precision and consistency, helping you avoid errors and stay confident in your results. It works smoothly across different devices, allowing you to access it whenever and wherever you need it. No complicated setup is required, just open it and start calculating instantly. Take advantage of this convenient tool to streamline your daily tasks and improve productivity. With everything you need in one place, managing numbers has never been easier. Explore its features, discover how it fits into your routine, and enjoy a smarter, more efficient way to handle calculations with ease and confidence every day";
    } 
    
}

function toggleDarkMode() {
    document.body.classList.toggle("dark");
}



/* textContent digunakan untuk mengubah teks murni di dalam elemen
        ciri2= 
        - tidak mengikuti CSS
        - tidak membaca tag html
        - aman dari serangan siber Cross-Site Scripting (XSS)

   innerText digunakan untuk mengubah isi dalam bentuk HTML
        ciri2=
        - mengikuti CSS
        - lebih lambat
        - tidak bisa membaca tag html

   innerHTML digunakan untuk mengubah teks di dalam elemen termasuk tag html
        ciri2=
        - bisa membaca tag html
        - lebih fleksibel
        - tidak aman dari serangan siber Cross-Site Scripting (XSS)
        
   berdasarkan perbedaan tersebut, textContent adalah yang paling aman untuk menghindari serangan siber Cross-Site Scripting (XSS)
*/
