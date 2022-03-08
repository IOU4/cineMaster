const postId = new URLSearchParams(window.location.search).get("id") || "1";

let getPost = async (postId) => {
  const post = await fetch(`http://localhost/api/post?id=${postId}`)
    .then((res) => res.json())
    .catch((err) => console.error(err));
  return post;
};

const printComments = (post, username, isLogged) => {
  let comments = "";
  post.comments.forEach((e) => {
    comments += `
              <div class="shadow-xl mb-4 p-4 rounded-md relative">
                <p>${e.content}</p>
                <span class="font-bold text-sm">${e.username}</span>
                <span class="text-xs absolute right-2 bottom-2">${e.created_at}</span>
                `;
    if (isLogged && username == e.username) {
      comments += `<div class="link" onclick="deleteComment(${e.id})">delete</div>`;
      comments += `<div class="link" onclick="updateComment(${e.id})">update</div>`;
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
  document
    .querySelector("#post-content a")
    .setAttribute("href", `user.html?user=${post.username}`);
  author.innerText = post.username;
  title.value = post.title;
  description.value = post.description;
  created_at.innerText = post.created_at;
  category.value = "Action";

  if (isLogged && post.username == username) {
    const postContent = document.getElementById("post-content");
    let deleteDiv = document.createElement("div");
    deleteDiv.setAttribute("class", "absolute top-8 right-2 link");
    deleteDiv.innerText = "delete";
    deleteDiv.onclick = () => deletePost(post.id);
    let updateDiv = document.createElement("div");
    updateDiv.setAttribute("class", "absolute top-8 right-24 link");
    updateDiv.innerText = "update";
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
  fetch("http://localhost/api/add/comment", {
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
  return await fetch("http://localhost/api/is_logged")
    .then((res) => res.json())
    .catch((err) => console.error(err));
};

const logout = async () => {
  await fetch("http://localhost/api/logout");
  window.location = "Athentication.html";
};

const deletePost = async (id) => {
  let form = new FormData();
  form.append("id", id);
  return await fetch("http://localhost/api/delete/post", {
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
  console.log(form.children);
  console.log("dddddddddddddddddddddddddd");
  console.log(form.childNodes);
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
    await fetch("http://localhost/api/update/post", {
      method: "POST",
      body: newForm,
    })
      .then((res) => res.json())
      .catch((err) => window.alert("failed" + err))
      .then(() => {
        form.childNodes.forEach((e) => {
          if (e.nodeName == "INPUT") e.setAttribute("disabled", "");
          window.location.reload();
        });
      });
  });
};

const deleteComment = async (id) => {
  let form = new FormData();
  form.append("id", id);
  return await fetch("http://localhost/api/delete/comment", {
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
    await fetch("http://localhost/api/update/comment", {
      method: "POST",
      body: newForm,
    })
      .then((res) => res.json())
      .catch((err) => window.alert("failed" + err))
      .then(() => {
        form.childNodes.forEach((e) => {
          if (e.nodeName == "INPUT") e.setAttribute("disabled", "");
          window.location.reload();
        });
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
