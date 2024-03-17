import navigation from "./navigation.mjs";
import { makeRequest, sha512, sleep } from "./utils.mjs";

navigation();

window.addEventListener("load", async () => {
  const formEl = document.getElementById("register-form");
  const usernameEl = document.getElementById("username");
  const passwordNewEl = document.getElementById("new-password");
  const passwordConfirmEl = document.getElementById("confirm-password");
  const emailEl = document.getElementById("email");
  const errorEl = document.getElementById("error");

  formEl.classList.remove("hide");

  formEl.addEventListener("submit", async (e) => {
    e.preventDefault();
    if (passwordNewEl.value !== passwordConfirmEl.value) {
      errorEl.innerText = "Passwords do not match";
      errorEl.classList.add("alert");
      return;
    }
    const passwordHash = await sha512(passwordNewEl.value);
    let data = {
      username: usernameEl.value,
      password: passwordHash,
      email: emailEl.value
    };
    const response = await makeRequest("/api/v1/register.php", data);
    if (response["success"] === true) {
      alert("Success:\n".response["data"]["message"]);
    } else {
      errorEl.innerText = response["data"]["message"];
      errorEl.classList.add("alert");
    }
  });
});
