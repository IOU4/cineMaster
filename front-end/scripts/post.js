const url = window.location.search;
const postId = new URLSearchParams(url).get("id") || "1";

let getPost = async (postId) => {
  const post = await fetch(`http://localhost/api/post?id=${postId}`)
    .then((res) => res.json())
    .catch((err) => console.error(err));
  return post;
};

const getUserIdFromCookies = () => {
  return document.cookie
    .split("; ")
    .find((e) => e.startsWith("user_id="))
    .split("=")[1];
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

let printPost = async (postId, callable) => {
  const post = await callable(postId);
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

const submitNewComment = async (e) => {
  e.preventDefault();
  const form = new FormData(e.target);
  form.append("author_id", getUserIdFromCookies());
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
  const status = await fetch("http://localhost/api/is_logged")
    .then((res) => res.json())
    .then((data) => data.isLogged)
    .catch((err) => console.error(err));
  return status;
};

const init = async () => {
  const stat = await isLogged();
  if (stat) {
    document.getElementById("add-comment").classList.remove("hidden");
    document.getElementById("add-comment").onsubmit = submitNewComment;
  } else document.getElementById("alert").classList.remove("hidden");
  printPost(postId, getPost);
};

init();
