# 🚀 Hyvä Theme Magento 2 Demo Project

A modern Magento 2 project built using the **Hyvä Theme ecosystem**, focused on performance, clean frontend architecture, GraphQL integration, and custom module development.

This repository showcases practical experience in:

- Hyvä Theme Development
- Magento 2 Frontend & Backend Customization
- Custom Module Development
- GraphQL APIs
- Tailwind CSS & Alpine.js
- Adobe Commerce Best Practices
- Custom Blog module with GraphQL and Hyvä Theme compatible
---

# 📌 Project Highlights

## ✅ Hyvä Theme Setup & Customization

- Installed and configured Hyvä Theme
- Created custom **Child Theme** extending `Hyva/default`
- Customized layouts, templates, CMS pages, and styles
- Implemented Tailwind CSS-based UI
- Used Alpine.js for lightweight interactivity
- Optimized frontend performance

---

# 🎨 Custom Hyvä Child Theme

## Theme Structure

```bash
app/design/frontend/Custom/hyva_child
````

## Parent Theme Inheritance

```xml
<parent>Hyva/default</parent>
```

## Included Customizations

* Custom homepage structure
* Tailwind CSS styling
* Hyvä template overrides
* Magento layout XML customization
* Responsive frontend implementation
* Performance-focused frontend architecture

---

# 📰 Custom Blog Module

## Module Name

```bash
Jaimin_Blog
```

## Features

* Blog Listing Page
* Blog Detail Page
* Admin Management
* SEO-Friendly URLs
* Responsive Hyvä Frontend
* Tailwind CSS Integration
* GraphQL Support
* Magento 2 Best Practices

---

# ⚡ GraphQL Integration

Implemented custom GraphQL APIs for the Blog module.

## Supported APIs

* Fetch Blog List
* Fetch Blog Details
* Custom GraphQL Schema
* Resolver Implementation

## Example GraphQL Query

```graphql
query {
  blogPosts(
    pageSize: 10
    currentPage: 1
    filter: { status: { eq: "1" } }
    sort: { created_at: DESC }
  ) {
    total_count
    page_info { current_page total_pages }
    items {
      post_id title author url_key
      created_at updated_at
    }
  }
}
```

---

# ⚙️ Technologies Used

| Technology   | Description              |
| ------------ | ------------------------ |
| Magento 2    | eCommerce Framework      |
| Hyvä Theme   | Modern Magento Frontend  |
| PHP 8+       | Backend Development      |
| GraphQL      | API Layer                |
| Tailwind CSS | Utility-First CSS        |
| Alpine.js    | Lightweight JS Framework |
| MySQL        | Database                 |
| Composer     | Dependency Management    |
| Docker       | For containers           |
---

# 🏗️ Hyvä Compatibility Approach

This project follows Hyvä development best practices:

* Removed unnecessary KnockoutJS dependency
* Lightweight Alpine.js components
* Tailwind-first frontend styling
* Minimal JavaScript usage
* Performance-optimized rendering
* Clean Magento architecture

---

# 📂 Installation

## Clone Repository

```bash
git clone https://github.com/jaimin30j/hyva-theme-project.git
```

## Install Dependencies

```bash
composer install
```

## Magento Setup

```bash
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
php bin/magento cache:flush
```

---

# 🎯 Configure Theme

Go to:

```bash
Admin → Content → Design → Configuration
```

Select Theme:

```bash
Custom/hyva_child
```

---

# 💡 What This Project Demonstrates

## Magento 2 Expertise

* Custom Module Development
* Theme Customization
* GraphQL APIs
* Magento Architecture
* Magento Best Practices

## Hyvä Expertise

* Child Theme Development
* Tailwind CSS Customization
* Alpine.js Integration
* Hyvä Compatibility
* Performance Optimization

---

# 🚀 Future Enhancements

Planned improvements:

* Blog Search
* Pagination in GraphQL
* Related Posts
* Hyvä UI Components
* API Authentication
* PWA Enhancements

---

# 👨‍💻 Author

## Jaimin Patel

Senior Magento 2 / Adobe Commerce Developer
Hyvä Theme Developer | GraphQL | Performance Optimization

📌 GitHub:
[https://github.com/jaimin30j](https://github.com/jaimin30j)

---

# 🔗 Repository

GitHub Repository:

👉 [https://github.com/jaimin30j/hyva-theme-project](https://github.com/jaimin30j/hyva-theme-project)

---

# ⭐ Purpose of This Repository

This repository was created to:

* Explore modern Magento 2 frontend architecture
* Practice Hyvä Theme development
* Build GraphQL-based Magento modules
* Demonstrate real-world Magento expertise
* Showcase performance-focused Magento development

---

# 📄 License

This project is created for learning, demonstration, and development purposes.

```
```
