document.cookie = "username=jawad;domain=localhost;path=/front-end";
document.cookie = "user_id=2";

getId = () =>
  document.cookie
    .split("; ")
    .find((e) => e.startsWith("user_id="))
    .split("=")[1];

document
  .querySelector('input[name="author_id"]')
  .setAttribute("value", getId());

submitNewPost = async () => {
  const form = new FormData(document.getElementById("add-post"));
  fetch("http://localhost/api/add/post", {
    method: "POST",
    body: form,
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      document.getElementById("posts").innerHTML = "";
      printPosts(getPosts);
    })
    .catch((error) => {
      console.error("Error:", error);
    });
};

const toggleTheme = () => {
  const theme = document.lastChild.getAttribute("data-theme");
  if (theme == "dark") document.lastChild.setAttribute("data-theme", "light");
  else document.lastChild.setAttribute("data-theme", "dark");
};

const getPosts = async () => {
  const posts = await fetch("http://localhost/api/posts")
    .then((res) => res.json())
    .catch((err) => console.error(err));
  return posts;
};

const submitNewComment = (id) => {
  const form = new FormData(document.getElementById(`comment-to-${id}`));
  form.append("author_id", getId());
  form.append("post_id", id);
  fetch("http://localhost/api/add/comment", {
    method: "POST",
    body: form,
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);
      document.getElementById("posts").innerHTML = "";
      printPosts(getPosts);
    })
    .catch((err) => console.error(err));
};

const printPosts = async (callable) => {
  const posts = await callable();
  let postsContainer = document.getElementById("posts");
  posts.forEach((post) => {
    postsContainer.innerHTML += `
        <div id="post" class="w-11/12 shadow-xl lg:w-9/12 card bg-base-200">
          <a href="post.html?id=${post.id}" >
            <img src="${
              post.cover || "https://api.lorem.space/image/movie?w=800&h=625"
            }"/>
          </a>
          <div class="card-body">
          <a href="user.html?user=${
            post.username
          }" class="flex items-center gap-4" >
            <div class="avatar w-6">
              <div class="rounded-full">
                <img src="https://api.lorem.space/image/face?hash=92310">
              </div>
            </div>
            <p>${post.username}</p>
          </a>
            <p class="text-xs">${post.created_at}</p>
            <h2 class="card-title">${post.title}</h2>
            <p>
              ${post.description}
            </p>
            <div class="justify-end card-actions">
              <div class="badge badge-outline">scince fiction</div>
            </div>
            <form id="comment-to-${post.id}" class="mt-4 input-group">
              <input
                type="text"
                name="content"
                placeholder="add a comment ..."
                class="input input-bordered"
              />
              <input onclick="submitNewComment(${
                post.id
              })" type="button" value="done" class="btn" />
            </form>
            <div class="divider">last</div>
            <div class="text-xl">${post.comments[0]?.username || ""}</div>
            <p class="text-xs">${post.comments[0]?.created_at || ""}</p>
            <div>${post.comments[0]?.content || ""}</div>
          </div>
        </div>
      `;
  });
};

printPosts(getPosts);
