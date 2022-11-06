import $ from "jquery"

const validateForm = (formData) => {
    const errors = {
        firstname: [],
        lastname: [],
        username: [],
        email: [],
        password: [],
        passwordConfirm: []
    }

    formData.forEach((value, key) => {
        if (key === 'firstname') {
            if (!value) {
                errors.firstname.push("This field is required");
            }

            if (value.length < 4) {
                errors.firstname.push("The firstname must be at least 3 characters long");
            }
        }

        if (key === 'lastname') {
            if (!value) {
                errors.lastname.push("This field is required");
            }

            if (value.length < 4) {
                errors.lastname.push("The lastname must be at least 3 characters long");
            }
        }

        if (key === 'username') {
            if (!value) {
                errors.username.push("This field is required");
            }

            if (value.length < 4) {
                errors.username.push("This username must be at least 4 characters long");
            }
        }

        if (key === 'email') {
            if (!value) {
                errors.email.push("This field is required");
            }

            if (!value.match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)) {
                errors.email.push("Please enter a valid email address !");
            }
        }

        if (key === 'password') {
            if (!value) {
                errors.password.push("This field is required");
            }

            if (value.length < 8) {
                errors.password.push("Password must be at least 8 characters long");
            }

            if (value.length > 20) {
                errors.password.push("Password must be at most 20 characters long");
            }

            if (!value.match(/[a-z]/)) {
                errors.password.push("Password must contain at least one lowercase letter");
            }

            if (!value.match(/[A-Z]/)) {
                errors.password.push("Password must contain at least one uppercase letter");
            }

            if (!value.match(/[0-9]/)) {
                errors.password.push("Password must contain at least one number");
            }

            if (!value.match(/[!@#$%^&*]/)) {
                errors.password.push("Password must contain at least one special character");
            }
        }

        if (key === 'passwordConfirm') {
            if (!value) {
                errors.passwordConfirm.push("This field is required");
            }

            if (value !== formData.get('password')) {
                errors.passwordConfirm.push("Passwords do not match");
            }
        }

    })

for (let errorKey in errors) {
    if (errors[errorKey].length !== 0) {
        return errors
    }
}
    return false
}

const displayError = (key, errors) => {
    $(`#${key}-invalid`).html(errors[key][0]).removeClass('hidden')
    $(`#${key}`).addClass('invalid')
}

$(document).ready(() => {
    $('input').on("focus", (event) => {
        event.target.classList.remove('invalid')
        $(`#${event.target.id}-invalid`).addClass('hidden')
    })

    $("#form").on("submit", (event) => {
        event.preventDefault()

        const submitBtn = $("#submitBtn").html("Loading...").prop("disabled", true)
        const formData = new FormData(event.target)
        let errors = validateForm(formData)

        if (errors) {
            for (let key in errors) {
                if (errors[key].length !== 0) {
                    displayError(key, errors);
                }
            }
        } else {
            $.ajax({
                url: 'api/v1/users',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: (data) => {
                    console.log(data);
                },
                error: (err) => {
                    console.log(err);
                }
            })
        }

        submitBtn.html("Submit").prop("disabled", false)
    })
})


