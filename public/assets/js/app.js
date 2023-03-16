(function () {
    const sidebarNode = document.querySelector('#sidebar')
    const toggle = sidebarNode.querySelector('[data-coreui-toggle]')
    let sidebar

    const storageKey = 'sidebar._unfoldable'

    if (localStorage.getItem(storageKey) === 'true') {
        sidebarNode.classList.add("sidebar-narrow-unfoldable");
    }

    window.addEventListener('load', () => {
        sidebar = coreui.Sidebar.getInstance(sidebarNode)
        // if (localStorage.getItem(storageKey) === 'true') {
        //     sidebar.toggleUnfoldable()
        // }
        // console.log(sidebar._unfoldable)
    })

    toggle.addEventListener('click', () => {
        console.log(sidebar._unfoldable)
        localStorage.setItem(storageKey, sidebar._unfoldable)
    })
})()