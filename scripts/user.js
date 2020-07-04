function changeForm(user) {
    const form = document.getElementById("userForm");
    form.setAttribute("action", "functions/changeUserRole.php?id=" + user);
}