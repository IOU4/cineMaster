const isLogged = async () => {
  return await fetch("/api/is_logged")
    .then((res) => res.json())
    .catch((err) => console.error(err));
};

const logout = async () => {
  await fetch("/api/logout");
  window.location = "Athentication.html";
};

const submitNewPost = async (e) => {
  e.preventDefault();
  const form = new FormData(e.target);
  fetch("/api/add/post", {
    method: "POST",
    body: form,
  })
    .then((response) => response.json())
    .then(async () => {
      document.getElementById("posts").innerHTML = "";
      const posts = await getPosts();
      printPosts(posts);
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
  return await fetch("/api/posts")
    .then((res) => res.json())
    .catch((err) => console.error(err));
};

const printPosts = (posts) => {
  let postsContainer = document.getElementById("posts");
  posts.forEach((post) => {
    postsContainer.innerHTML += `
        <a href="post.html?id=${
          post.id
        }" id="post" class="shadow-xl w-full card bg-base-200">
          <figure>
            <img src="/api/uploaded/${
              post.cover ? post.cover : "not_found.jpg"
            }"/>
          </figure>
          <div class="card-body">
          <div class="flex items-center gap-4" >
            <div class="avatar w-6">
              <div class="rounded-full">
                <img src="https://api.lorem.space/image/face?hash=92310">
              </div>
            </div>
            <p>${post.username}</p>
          </div>
            <p class="text-xs">${post.created_at}</p>
            <h2 class="card-title">${post.title}</h2>
            <p>${post.description}</p>
            <div class="justify-end card-actions">
              <div class="badge badge-outline">scince fiction</div>
            </div>
            <div class="divider"></div>
            <div class="text-xl">${post.comments[0]?.username || ""}</div>
            <p class="text-xs">${post.comments[0]?.created_at || ""}</p>
            <div>${post.comments[0]?.content || ""}</div>
          </div>
        </a>
      `;
  });
};

const init = async () => {
  const logged = await isLogged();
  const posts = await getPosts();
  if (logged.isLogged) {
    document.getElementById("logout").innerText = "Logout";
    document.getElementById("add-post").classList.remove("hidden");
    document.getElementById("add-post").onsubmit = submitNewPost;
  } else document.getElementById("alert").classList.remove("hidden");
  printPosts(posts);
};

init();
