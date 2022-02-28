let getOnePost = async (postId) => {
  const post = await fetch(`http://localhost/api/post?id=${postId}`)
    .then((res) => res.json())
    .catch((err) => console.error(err));
  return post;
};

let printOnePost = async (callable, postId) => {
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
  let comments = "";
  post.comments.forEach((e) => {
    comments += `
              <div class="font-bold">${e?.username || ""}</div>
              <div class="text-sm">${e?.created_at || ""}</div>
              <p class="mb-4">${e?.content || ""}</p>
                `;
  });
  document.querySelector("main").innerHTML += comments;
};

const url = window.location.search;
const postId = new URLSearchParams(url).get("id");
printOnePost(getOnePost, postId);
