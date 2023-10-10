import navigation from "./navigation.mjs";
import { makeRequest, sha512, sleep } from "./utils.mjs";

navigation();

window.addEventListener("load", async () => {
  const form = document.getElementById("login-form");
  const username = document.getElementById("username");
  const password = document.getElementById("password");
  const error = document.getElementById("error");

  form.classList.remove("hide");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    let time = Math.floor(Date.now() / 1000);
    let passwordHash = await sha512((await sha512(password)) + time);
    let data = {
      auth: {
        time: time,
        username: username,
        password: passwordHash,
      },
    };
    const response = await makeRequest("/api/v1/login.php", data);
    if (response["success"] === true) {
      form.classList.add("hide");
      await sleep(1000);
      sessionStorage.setItem("token", response["data"]["token"]);
      if (window.location.hash.startsWith("#redirect=")) {
        window.location = window.location.hash.substring(10);
      } else {
        window.location = "/dashboard";
      }
    } else {
      error.innerText = response["data"];
      error.classList.add("alert");
    }
  });
});
