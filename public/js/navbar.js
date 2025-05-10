function toggleMenu() {
    const nav = document.getElementById("nav");
    nav.classList.toggle("active");
  }


  document.addEventListener("click", function(e) {
    const siswaDropdown = document.getElementById("dropdownSiswa");
    const guruDropdown = document.getElementById("dropdownGuru");

    if (!e.target.closest("li")) {
      siswaDropdown.classList.remove("show");
      guruDropdown.classList.remove("show");
    }
  });

  function toggleDropdownSiswa(event) {
    event.preventDefault();
    document.getElementById("dropdownSiswa").classList.toggle("show");
  }

  function toggleDropdownGuru(event) {
    event.preventDefault();
    document.getElementById("dropdownGuru").classList.toggle("show");
  }

  function toggleUserDropdown(event) {
    event.preventDefault();
    const userDropdown = document.getElementById("userDropdown");
    userDropdown.classList.toggle("show");
}

// Close user dropdown when clicking outside
document.addEventListener("click", function(e) {
    const userMenu = document.getElementById("userMenu");
    const userDropdown = document.getElementById("userDropdown");

    if (!userMenu.contains(e.target)) {
        userDropdown.classList.remove("show");
    }
});
