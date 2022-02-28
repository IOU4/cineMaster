let toggleTheme = () => {
  const theme = document.lastChild.getAttribute("data-theme");
  if (theme == "dark") document.lastChild.setAttribute("data-theme", "light");
  else document.lastChild.setAttribute("data-theme", "dark");
};
let getUserPosts = async (username) => {
  let posts = await fetch(`http://localhost/api/posts?author=${username}`)
    .then((res) => res.json())
    .catch((err) => console.error(err));
  return posts;
};
let printUserPosts = async (callable, username) => {
  const posts = await callable(username);
  let postsContainer = document.getElementById("posts");
  posts.forEach((post) => {
    postsContainer.innerHTML += `
    <div id="post" class="w-11/12 shadow-xl lg:w-9/12 card bg-base-200">
      <figure>
        <img src="https://api.lorem.space/image/movie?w=800&h=625" />
      </figure>
      <div class="card-body">
      <div class="flex gap-4 items-center">
        <div class="w-6 avatar">
          <div class="rounded-full">
            <img src="https://api.lorem.space/image/face?hash=92310">
          </div>
        </div>
        <p>${post.username}</p>
      </div>
        <p class="text-xs">${post.created_at}</p>
        <h2 class="card-title">${post.title}</h2>
        <p>
          ${post.description}
        </p>
        <div class="justify-end card-actions">
          <div class="badge badge-outline">scince fiction</div>
        </div>
        <form class="mt-4 input-group">
          <input
            type="text"
            name="comment"
            placeholder="add a comment ..."
            class="input input-bordered"
          />
          <input type="submit" value="done" class="btn" />
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

const getUserProfile = async (username) => {
  const user = fetch(`http://localhost/api/user?username=${username}`)
    .then((res) => res.json())
    .catch((err) => console.error(err));
  return user;
};

const printUserProfile = async (callable, username) => {
  let name = document.querySelector("input[name='username']");
  let email = document.querySelector("input[name='email']");
  const user = await callable(username);
  email.setAttribute("value", user.email);
  name.setAttribute("value", user.username);
};

let username = new URLSearchParams(window.location.search).get("user");
printUserProfile(getUserProfile, username);
printUserPosts(getUserPosts, username);
