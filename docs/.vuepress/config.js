import { defaultTheme } from 'vuepress'

export default {
  base: '/docs/',
  dest: 'public/docs',
  title:'SaaS Boilerplate Pro Docs',
  description:'This is description',
  head: [
    ['link', { rel: 'icon', type: "image/svg+xml", href: '/icon.svg' }]
  ],
  theme: defaultTheme({
    navbar: [
      { text: 'Home', link: '/' },
      { text: 'Download', link: '/getstarted/' }
    ],
    sidebar: [
      {
        text: 'Welcome',
        link: '/'
      },
      {
        text: 'Getting Started',
        collapsible: false,
        children: [
          {
            text: 'Downloading',
            link: '/getstarted/'
          },
          {
            text: 'Installation',
            link: '/getstarted/installation.md'
          },
          {
            text: 'Features',
            link: '/getstarted/features.md'
          },
          {
            text: 'Folder Structure',
            link: '/getstarted/folders.md'
          },
          {
            text: 'Commands',
            link: '/getstarted/commands.md'
          }
        ]
      },
      {
        text: 'Configuration',
        collapsible: false,
        children: [
          {
            text: 'Basics',
            link: '/config/'
          },
          {
            text: 'Advanced',
            link: '/config/advanced.md'
          }
        ]
      },
      {
        text: 'Teams',
        collapsible: false,
        children: [
          {
            text: 'Introduction',
            link: '/teams/'
          },
          {
            text: 'Users & Roles',
            link: '/teams/users.md'
          },
          {
            text: 'Subscriptions',
            link: '/teams/subscriptions.md'
          },
          {
            text: 'Multi-tenancy',
            link: '/teams/multi-tenancy.md',
            children: []
          }
        ]
      },
      {
        text: 'User Account',
        collapsible: false,
        children: [
          {
            text: 'Introduction',
            link: '/account/'
          },
          {
            text: 'Profile',
            link: '/account/profile.md'
          },
          {
            text: 'Subscriptions',
            link: '/account/subscriptions.md'
          },
          {
            text: 'Personal Access Tokens',
            link: '/account/tokens.md'
          }
        ]
      }
    ]
  })
}
