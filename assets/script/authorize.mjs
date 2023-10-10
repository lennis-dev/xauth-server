import navigation from "./navigation.mjs";
import { makeRequest, postForm, sleep } from "./utils.mjs";

navigation();
var data = {};
window.addEventListener("load", async () => {
  const form = document.getElementById("authorize-form");
  const urlHash = window.location.hash.substring(1);
  const error = document.getElementById("error");
  const authorize = document.getElementById("authorize");
  const deny = document.getElementById("deny");
  try {
    data = JSON.parse(atob(urlHash));
    document.getElementById("name").innerText = data["name"];
    document.getElementById("domain").innerText = new URL(data["redirect"]).origin;
    document.getElementById("scopes").innerText = data["scopes"].join(", ");
    document.getElementById("redirect").innerText = data["redirect"];
  } catch (e) {
    error.innerText = "Invalid request: " + e;
    error.classList.add("alert");
    form.classList.remove("hide");
    return;
  }
  form.classList.remove("hide");

  authorize.addEventListener("click", async (e) => {
    const postData = {
      token: sessionStorage.getItem("token"),
      scopes: data["scopes"],
    };
    const result = await makeRequest("/api/v1/authorize.php", postData);
    form.classList.add("hide");
    await sleep(1000);
    if (result["success"]) {
      postForm(data["redirect"], { token: result["data"]["token"] });
    } else {
      alert("Error: " + result["message"]);
    }
  });

  deny.addEventListener("click", async (e) => {
    form.classList.add("hide");
    await sleep(1000);
    postForm(data["redirect"]);
  });
});
