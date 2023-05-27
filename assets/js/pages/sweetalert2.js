import Swal from 'sweetalert2'

let deleteUser = document.getElementById("delete-user");
if (deleteUser !== null) {
    deleteUser.addEventListener("click", (e) => {
        Swal.fire({
            title: 'Confirmación',
            text: "¿Está seguro de borrar el usuario?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000066',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteUserForm').submit();
                Swal.fire(
                    'Borrado!',
                    'El usuario ha sido borrado.',
                    'success'
                )
            }
        })
    })
}


let deleteAfc = document.getElementById("delete-afc");
if (deleteAfc !== null) {
    deleteAfc.addEventListener("click", (e) => {
        Swal.fire({
            title: 'Confirmación',
            text: "¿Está seguro de borrar la Afc?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000066',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteAfcForm').submit();
                Swal.fire(
                    'Borrado!',
                    'Afc borrada.',
                    'success'
                )
            }
        })
    })

}

let deleteAfp = document.getElementById("delete-afp");
if (deleteAfp !== null) {
    deleteAfp.addEventListener("click", (e) => {
        Swal.fire({
            title: 'Confirmación',
            text: "¿Está seguro de borrar la Afp?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000066',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteAfpForm').submit();
                Swal.fire(
                    'Borrado!',
                    'Afp borrada.',
                    'success'
                )
            }
        })
    })

}


let deleteEps = document.getElementById("delete-eps");
if (deleteEps !== null) {
    deleteEps.addEventListener("click", (e) => {
        Swal.fire({
            title: 'Confirmación',
            text: "¿Está seguro de borrar la Eps?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000066',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteEpsForm').submit();
                Swal.fire(
                    'Borrado!',
                    'Eps borrada.',
                    'success'
                )
            }
        })
    })

}

let deleteCargo = document.getElementById("delete-cargo");
if (deleteCargo !== null) {
    deleteCargo.addEventListener("click", (e) => {
        Swal.fire({
            title: 'Confirmación',
            text: "¿Está seguro de borrar el cargo?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000066',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteCargoForm').submit();
                Swal.fire(
                    'Borrado!',
                    'Cargo borrado.',
                    'success'
                )
            }
        })
    })

}


let deletePersonal = document.getElementById("delete-personal");
if (deletePersonal !== null) {
    deletePersonal.addEventListener("click", (e) => {
        Swal.fire({
            title: 'Confirmación',
            text: "¿Está seguro de borrar el personal?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000066',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deletePersonalForm').submit();
                Swal.fire(
                    'Borrado!',
                    'Personal borrado.',
                    'success'
                )
            }
        })
    })

}


/*

document.getElementById("basic").addEventListener("click", (e) => {
  Swal.fire("Any fool can use a computer")
})
document.getElementById("footer").addEventListener("click", (e) => {
  Swal.fire({
    icon: "error",
    title: "Oops...",
    text: "Something went wrong!",
    footer: "<a href>Why do I have this issue?</a>",
  })
})
document.getElementById("title").addEventListener("click", (e) => {
  Swal.fire("The Internet?", "That thing is still around?", "question")
})
document.getElementById("success").addEventListener("click", (e) => {
  Swal.fire({
    icon: "success",
    title: "Success",
  })
})
document.getElementById("error").addEventListener("click", (e) => {
  Swal.fire({
    icon: "error",
    title: "Error",
  })
})
document.getElementById("warning").addEventListener("click", (e) => {
  Swal.fire({
    icon: "warning",
    title: "Warning",
  })
})
document.getElementById("info").addEventListener("click", (e) => {
  Swal.fire({
    icon: "info",
    title: "Info",
  })
})
document.getElementById("question").addEventListener("click", (e) => {
  Swal.fire({
    icon: "question",
    title: "Question",
  })
})
document.getElementById("text").addEventListener("click", (e) => {
  Swal.fire({
    title: "Enter your IP address",
    input: "text",
    inputLabel: "Your IP address",
    showCancelButton: true,
  })
})
document.getElementById("email").addEventListener("click", async (e) => {
  const { value: email } = await Swal.fire({
    title: "Input email address",
    input: "email",
    inputLabel: "Your email address",
    inputPlaceholder: "Enter your email address",
  })

  if (email) {
    Swal.fire(`Entered email: ${email}`)
  }
})
document.getElementById("url").addEventListener("click", async (e) => {
  const { value: url } = await Swal.fire({
    input: "url",
    inputLabel: "URL address",
    inputPlaceholder: "Enter the URL",
  })

  if (url) {
    Swal.fire(`Entered URL: ${url}`)
  }
})
document.getElementById("password").addEventListener("click", async (e) => {
  const { value: password } = await Swal.fire({
    title: "Enter your password",
    input: "password",
    inputLabel: "Password",
    inputPlaceholder: "Enter your password",
    inputAttributes: {
      maxlength: 10,
      autocapitalize: "off",
      autocorrect: "off",
    },
  })

  if (password) {
    Swal.fire(`Entered password: ${password}`)
  }
})
document.getElementById("textarea").addEventListener("click", async (e) => {
  const { value: text } = await Swal.fire({
    input: "textarea",
    inputLabel: "Message",
    inputPlaceholder: "Type your message here...",
    inputAttributes: {
      "aria-label": "Type your message here",
    },
    showCancelButton: true,
  })

  if (text) {
    Swal.fire(text)
  }
})
document.getElementById("select").addEventListener("click", async (e) => {
  const { value: fruit } = await Swal.fire({
    title: "Select field validation",
    input: "select",
    inputOptions: {
      Fruits: {
        apples: "Apples",
        bananas: "Bananas",
        grapes: "Grapes",
        oranges: "Oranges",
      },
      Vegetables: {
        potato: "Potato",
        broccoli: "Broccoli",
        carrot: "Carrot",
      },
      icecream: "Ice cream",
    },
    inputPlaceholder: "Select a fruit",
    showCancelButton: true,
    inputValidator: (value) => {
      return new Promise((resolve) => {
        if (value === "oranges") {
          resolve()
        } else {
          resolve("You need to select oranges :)")
        }
      })
    },
  })

  if (fruit) {
    Swal.fire(`You selected: ${fruit}`)
  }
})
*/
