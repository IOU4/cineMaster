let toggleTheme = () => {
  const theme = document.lastChild.getAttribute("data-theme");
  if (theme == "dark") document.lastChild.setAttribute("data-theme", "light");
  else document.lastChild.setAttribute("data-theme", "dark");
};

let getPosts = async () => {
  return data;
};

let printPosts = async () => {
  let postsContainer = document.getElementById("posts");
  const posts = await fetch("http://localhost/api/posts")
    .then((res) => res.json())
    .catch((err) => console.error(err));
  await posts.forEach((post) => {
    postsContainer.innerHTML += `
        <div id="post" class="w-11/12 shadow-xl lg:w-9/12 card bg-base-200">
          <figure>
            <img src="https://api.lorem.space/image/movie?w=800&h=625" />
          </figure>
          <div class="card-body">
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
            <div class="text-xl">imad ouchaib</div>
            <p class="text-xs">22/02 13:44</p>
            <div>this is a great movie</div>
          </div>
        </div>
      `;
  });
};
printPosts();
