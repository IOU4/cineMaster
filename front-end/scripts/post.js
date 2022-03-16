const postId = new URLSearchParams(window.location.search).get("id") || "1";

let getPost = async (postId) => {
  const post = await fetch(`/api/post?id=${postId}`)
    .then((res) => res.json())
    .catch((err) => console.error(err));
  return post;
};

const printComments = (post, username, isLogged) => {
  let comments = "";
  post.comments.forEach((e) => {
    comments += `
              <div class="shadow-xl mb-4 p-4 rounded-md relative">
                <form id="comment-${e.id}" class="input-group">
                  <input name="content" class="input input-bordered" value="${e.content}" disabled>
                </form>
                <span class="font-bold text-sm">${e.username}</span>
                <span class="text-xs absolute right-2 bottom-2">${e.created_at}</span>
                `;
    if (isLogged && username == e.username) {
      comments += `<div class="link" onclick="deleteComment(${e.id})"><svg class="w-4 absolute top-1 right-1 fill-current" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="trash-2"><rect width="24" height="24" opacity="0"/><path d="M21 6h-5V4.33A2.42 2.42 0 0 0 13.5 2h-3A2.42 2.42 0 0 0 8 4.33V6H3a1 1 0 0 0 0 2h1v11a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V8h1a1 1 0 0 0 0-2zM10 4.33c0-.16.21-.33.5-.33h3c.29 0 .5.17.5.33V6h-4zM18 19a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V8h12z"/><path d="M9 17a1 1 0 0 0 1-1v-4a1 1 0 0 0-2 0v4a1 1 0 0 0 1 1zM15 17a1 1 0 0 0 1-1v-4a1 1 0 0 0-2 0v4a1 1 0 0 0 1 1z"/></g></g></svg></div>`;
      comments += `<div class="link" onclick="updateComment(${e.id})"><svg class="w-4 absolute top-1 right-7 fill-current" viewBox="0 0 512 512"><path d="M362.7 19.32C387.7-5.678 428.3-5.678 453.3 19.32L492.7 58.75C517.7 83.74 517.7 124.3 492.7 149.3L444.3 197.7L314.3 67.72L362.7 19.32zM421.7 220.3L188.5 453.4C178.1 463.8 165.2 471.5 151.1 475.6L30.77 511C22.35 513.5 13.24 511.2 7.03 504.1C.8198 498.8-1.502 489.7 .976 481.2L36.37 360.9C40.53 346.8 48.16 333.9 58.57 323.5L291.7 90.34L421.7 220.3z"/></svg></div>`;
    }
    comments += "</div>";
  });
  document.getElementById("comments").innerHTML = "";
  document.getElementById("comments").innerHTML = comments;
};

let printPost = (post, username, isLogged) => {
  let author = document.getElementById("username");
  let title = document.querySelector("input[name='title']");
  let description = document.querySelector("input[name='description']");
  let created_at = document.getElementById("created_at");
  let category = document.querySelector("input[name='category']");
  let cover = document.getElementById("cover");
  document
    .querySelector("#post-content a")
    .setAttribute("href", `user.html?user=${post.username}`);
  author.innerText = post.username;
  title.value = post.title;
  description.value = post.description;
  created_at.innerText = post.created_at;
  category.value = "Action";
  cover.setAttribute(
    "style",
    `background-image: url(/api/uploaded/${post.cover});`
  );
  if (isLogged && post.username == username) {
    const postContent = document.getElementById("post-content");
    let deleteDiv = document.createElement("div");
    deleteDiv.setAttribute("class", "absolute top-8 right-2 link");
    deleteDiv.innerHTML = `<svg class="w-4 fill-current" viewBox="0 0 448 512"><path d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM31.1 128H416V448C416 483.3 387.3 512 352 512H95.1C60.65 512 31.1 483.3 31.1 448V128zM111.1 208V432C111.1 440.8 119.2 448 127.1 448C136.8 448 143.1 440.8 143.1 432V208C143.1 199.2 136.8 192 127.1 192C119.2 192 111.1 199.2 111.1 208zM207.1 208V432C207.1 440.8 215.2 448 223.1 448C232.8 448 240 440.8 240 432V208C240 199.2 232.8 192 223.1 192C215.2 192 207.1 199.2 207.1 208zM304 208V432C304 440.8 311.2 448 320 448C328.8 448 336 440.8 336 432V208C336 199.2 328.8 192 320 192C311.2 192 304 199.2 304 208z"/></svg>`;
    deleteDiv.onclick = () => deletePost(post.id);
    let updateDiv = document.createElement("div");
    updateDiv.setAttribute("class", "absolute top-8 right-10 link");
    updateDiv.innerHTML = `<svg class="w-4 fill-current" viewBox="0 0 512 512"><path d="M362.7 19.32C387.7-5.678 428.3-5.678 453.3 19.32L492.7 58.75C517.7 83.74 517.7 124.3 492.7 149.3L444.3 197.7L314.3 67.72L362.7 19.32zM421.7 220.3L188.5 453.4C178.1 463.8 165.2 471.5 151.1 475.6L30.77 511C22.35 513.5 13.24 511.2 7.03 504.1C.8198 498.8-1.502 489.7 .976 481.2L36.37 360.9C40.53 346.8 48.16 333.9 58.57 323.5L291.7 90.34L421.7 220.3z"/></svg>`;
    updateDiv.onclick = () => updatePost(post.id);
    postContent.append(updateDiv, deleteDiv);
  }
};

const toggleTheme = () => {
  const theme = document.lastChild.getAttribute("data-theme");
  if (theme == "dark") document.lastChild.setAttribute("data-theme", "light");
  else document.lastChild.setAttribute("data-theme", "dark");
};

const submitNewComment = async (e) => {
  e.preventDefault();
  const form = new FormData(e.target);
  form.append("post_id", postId);
  fetch("/api/add/comment", {
    method: "POST",
    body: form,
  })
    .then((res) => res.json())
    .then(async () => {
      const post = await getPost(postId);
      const logged = await isLogged();
      printComments(post, logged?.username, true);
    })
    .catch((err) => console.error(err));
};

const isLogged = async () => {
  return await fetch("/api/is_logged")
    .then((res) => res.json())
    .catch((err) => console.error(err));
};

const logout = async () => {
  await fetch("/api/logout");
  window.location = "Athentication.html";
};

const deletePost = async (id) => {
  let form = new FormData();
  form.append("id", id);
  return await fetch("/api/delete/post", {
    method: "POST",
    body: form,
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);
      window.location = "posts.html";
    })
    .catch((err) => console.error(err));
};

const updatePost = async (id) => {
  let form = document.getElementById("post-content");
  form.childNodes.forEach((e) => {
    if (e.nodeName == "INPUT") e.removeAttribute("disabled");
  });
  let submit = document.createElement("button");
  submit.setAttribute("class", "btn btn-primary");
  submit.innerText = "Update";
  form.appendChild(submit);
  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    let newForm = new FormData(form);
    newForm.append("id", id);
    await fetch("/api/update/post", {
      method: "POST",
      body: newForm,
    })
      .then((res) => res.json())
      .catch((err) => window.alert("failed" + err))
      .then(() => {
        form.childNodes.forEach((e) => {
          if (e.nodeName == "INPUT") e.setAttribute("disabled", "");
        });
        submit.remov();
      });
  });
};

const deleteComment = async (id) => {
  let form = new FormData();
  form.append("id", id);
  return await fetch("/api/delete/comment", {
    method: "POST",
    body: form,
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);
      window.location.reload();
    })
    .catch((err) => console.error(err));
};

const updateComment = async (id) => {
  const form = document.getElementById(`comment-${id}`);
  form.childNodes.forEach((n) => {
    if (n.nodeName == "INPUT") n.removeAttribute("disabled");
  });
  let submit = document.createElement("button");
  submit.setAttribute("class", "btn");
  submit.innerText = "done";
  form.appendChild(submit);
  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    let newForm = new FormData(form);
    newForm.append("id", id);
    await fetch("/api/update/comment", {
      method: "POST",
      body: newForm,
    })
      .then((res) => res.json())
      .catch((err) => window.alert("failed" + err))
      .then(() => {
        form.childNodes.forEach((e) => {
          if (e.nodeName == "INPUT") e.setAttribute("disabled", "");
        });
        submit.remove();
      });
  });
};

const init = async () => {
  const logged = await isLogged();
  const post = await getPost(postId);
  if (logged.isLogged) {
    document.getElementById("logout").innerText = "Logout";
    document.getElementById("add-comment").classList.remove("hidden");
    document.getElementById("add-comment").onsubmit = submitNewComment;
  } else document.getElementById("alert").classList.remove("hidden");
  printPost(post, logged?.username, logged.isLogged);
  printComments(post, logged?.username, logged.isLogged);
};

init();
