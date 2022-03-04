const postId = new URLSearchParams(window.location.search).get("id") || "1";

let getPost = async (postId) => {
  const post = await fetch(`http://localhost/api/post?id=${postId}`)
    .then((res) => res.json())
    .catch((err) => console.error(err));
  return post;
};

const printComments = (post) => {
  let comments = "";
  post.comments.forEach((e) => {
    comments += `
              <div class="shadow-xl mb-4 p-4 rounded-md relative">
                <p>${e.content}</p>
                <span class="font-bold text-sm">${e.username}</span>
                <span class="text-xs absolute right-2 bottom-2">${e.created_at}</span>
              </div>
                `;
  });
  document.getElementById("comments").innerHTML = "";
  document.getElementById("comments").innerHTML = comments;
};

let printPost = (post) => {
  let author = document.getElementById("username");
  let title = document.getElementById("title");
  let description = document.getElementById("description");
  let created_at = document.getElementById("created_at");
  document
    .querySelector("#post-content a")
    .setAttribute("href", `user.html?user=${post.username}`);
  author.innerText = post.username;
  title.innerText = post.title;
  description.innerText = post.description;
  created_at.innerText = post.created_at;
  printComments(post);
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
      printComments(post);
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

const init = async () => {
  const logged = await isLogged();
  const post = await getPost(postId);
  if (logged.isLogged) {
    document.getElementById("logout").innerText = "Logout";
    document.getElementById("add-comment").classList.remove("hidden");
    if (logged.username == post.username) {
      const postContent = document.querySelector("#post-content");
      postContent.innerHTML += `<div class="absolute top-2 right-2 link" onclick="deletePost(${post.id})">delete</div>`;
      postContent.innerHTML += `<div id="update" class="absolute top-8 right-2 link">update</div>`;
    }
    document.getElementById("add-comment").onsubmit = submitNewComment;
  } else document.getElementById("alert").classList.remove("hidden");
  printPost(post);
};

init();
