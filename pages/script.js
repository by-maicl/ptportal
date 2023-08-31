document.addEventListener("DOMContentLoaded", () => {
    const likeButtons = document.querySelectorAll(".like-button");
    const unlikeButtons = document.querySelectorAll(".unlike-button");

    likeButtons.forEach(button => {
        button.addEventListener("click", () => {
            const objectDiv = button.closest(".likeable-object");
            const objectId = objectDiv.getAttribute("data-id");
            const likesCountSpan = objectDiv.querySelector(".likes-count");
            const usernameInput = objectDiv.querySelector(".username-input");
            const username = usernameInput.value;

            if (!username) {
                alert("Введіть ваше ім'я");
                return;
            }

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "like.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        likesCountSpan.textContent = xhr.responseText;
                        button.style.display = "none";
                        objectDiv.querySelector(".unlike-button").style.display = "inline";
                        usernameInput.disabled = true; // Заборона редагування імені
                    } else {
                        console.error("Помилка при взаємодії з сервером");
                    }
                }
            };
            xhr.send(`object_id=${objectId}&username=${username}`);
        });
    });

    unlikeButtons.forEach(button => {
        button.addEventListener("click", () => {
            const objectDiv = button.closest(".likeable-object");
            const objectId = objectDiv.getAttribute("data-id");
            const likesCountSpan = objectDiv.querySelector(".likes-count");
            const usernameInput = objectDiv.querySelector(".username-input");
            const username = usernameInput.value;

            if (!username) {
                alert("Введіть ваше ім'я");
                return;
            }

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "like.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        likesCountSpan.textContent = xhr.responseText;
                        button.style.display = "none";
                        objectDiv.querySelector(".like-button").style.display = "inline";
                        usernameInput.disabled = true; // Заборона редагування імені
                    } else {
                        console.error("Помилка при взаємодії з сервером");
                    }
                }
            };
            xhr.send(`object_id=${objectId}&username=${username}`);
        });
    });

    // Завантаження лічильників лайків при завантаженні сторінки
    loadLikesCounts();
});

function loadLikesCounts() {
    const likeableObjects = document.querySelectorAll(".likeable-object");

    likeableObjects.forEach(object => {
        const objectId = object.getAttribute("data-id");
        const likesCountSpan = object.querySelector(".likes-count");
        const usernameInput = object.querySelector(".username-input");
        const username = usernameInput.value;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "get_likes_count.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    likesCountSpan.textContent = xhr.responseText;

                    // Перевірка, чи вже ставив лайк
                    const xhrCheck = new XMLHttpRequest();
                    xhrCheck.open("POST", "check_like.php", true);
                    xhrCheck.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhrCheck.onreadystatechange = () => {
                        if (xhrCheck.readyState === XMLHttpRequest.DONE) {
                            if (xhrCheck.status === 200) {
                                if (xhrCheck.responseText === "true") {
                                    object.querySelector(".like-button").style.display = "none";
                                    object.querySelector(".unlike-button").style.display = "inline";
                                    usernameInput.disabled = true;
                                } else {
                                    object.querySelector(".like-button").style.display = "inline";
                                    object.querySelector(".unlike-button").style.display = "none";
                                }
                            }
                        }
                    };
                    xhrCheck.send(`object_id=${objectId}&username=${username}`);
                } else {
                    console.error("Помилка при взаємодії з сервером");
                }
            }
        };
        xhr.send(`object_id=${objectId}`);
    });
}
