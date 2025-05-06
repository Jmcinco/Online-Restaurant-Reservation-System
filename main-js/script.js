// CHILD 1
var userimage=document.querySelector("#userimage")
var overlay=document.querySelector(".overlay")
var cross=document.querySelector(".overlay .fa-close")
var plus=document.querySelector(".fa-plus")

plus.addEventListener('click', () => {
    plus.classList.toggle('plusred')
})

userimage.addEventListener('click', () => {
    overlay.classList.remove('d-none')
})


cross.addEventListener('click', () => {
    overlay.classList.add('d-none')
})

// CHILD 2
var userimage1=document.querySelector("#userimage1")
var overlay1=document.querySelector(".overlay1")
var cross1=document.querySelector(".overlay1 .fa-close")
var plus=document.querySelector(".fa-plus")

plus.addEventListener('click', () => {
    plus.classList.toggle('plusred')
})

userimage1.addEventListener('click', () => {
    overlay1.classList.remove('d-none')
})


cross1.addEventListener('click', () => {
    overlay1.classList.add('d-none')
})

// CHILD 3
var userimage2=document.querySelector("#userimage2")
var overlay2=document.querySelector(".overlay2")
var cross2=document.querySelector(".overlay2 .fa-close")
var plus=document.querySelector(".fa-plus")

plus.addEventListener('click', () => {
    plus.classList.toggle('plusred')
})

userimage2.addEventListener('click', () => {
    overlay2.classList.remove('d-none')
})


cross2.addEventListener('click', () => {
    overlay2.classList.add('d-none')
})

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})


function confirmation() {
    if(confirm("Approve this reservation?")) {
        return true
    } else {
        return false
    }
}

function disapprove() {
    if(confirm("Remove this reservation?")) {
        return true
    } else {
        return false
    }
}

function removeItem() {
    if(confirm("Remove this item?")) {
        return true
    } else {
        return false
    }
}

function updateData() {
    if(confirm("Update this item?")) {
        return true
    } else {
        return false
    }
}

function addItem() {
    if(confirm("Add this item?")) {
        return true
    } else {
        return false
    }
}

function adminLogout() {
    if(confirm("Are you sure you want to logout?")) {
        location.href="logout.php"
    } else {
        return false
    }
}

function markAsDone() {
    if(confirm("Mark this as done?")) {
        return true
    } else {
        return false
    }
}

function onlyNumberKey(evt) {
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
      return false;
    return true;
}
