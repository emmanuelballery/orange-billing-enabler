<template lang="pug">
    .container
        header.d-flex.flex-wrap.justify-content-center.py-3.mb-4.border-bottom
            a.d-flex.align-items-center.mb-3.mb-md-0.me-md-auto.text-dark.text-decoration-none(href='/')
                svg.bi.me-2(width=40, height=32)
                    use(xlink:href='#boosted')
                span.fs-4 Aviso Océane Bridge
            ul.nav.nav-pills
                li.nav-item
                    router-link.nav-link(:to='{name:"tickets"}', active-class="active") Tickets
                li.nav-item
                    router-link.nav-link(:to='{name:"categories"}', active-class="active") Categories
                li.nav-item
                    router-link.nav-link(:to='{name:"priorities"}', active-class="active") Priorities
                li.nav-item
                    router-link.nav-link(:to='{name:"services"}', active-class="active") Services
        router-view
</template>
