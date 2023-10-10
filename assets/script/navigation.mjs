export default function () {
  if (sessionStorage.getItem("token") == null && window.location.pathname != "/login" && window.location.pathname != "/register") {
    window.location.href = "/login#redirect=" + window.location.pathname + window.location.search + window.location.hash;
  } else if (sessionStorage.getItem("token") != null && (window.location.pathname == "/login" || window.location.pathname == "/register")) {
    window.location.href = "/dashboard";
  }
}
