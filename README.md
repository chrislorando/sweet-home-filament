<img width="1341" height="591" alt="Image" src="https://github.com/user-attachments/assets/d0320643-7a96-4158-b95b-3b449e80fb20" />

# Sweet Home - Real Estate Platform

> **Note**: This is a prototype project built as a portfolio piece based on a public job posting from Upwork. It demonstrates proficiency in Laravel 12, Filament 4, and modern PHP development practices.

A comprehensive real estate management platform built with Laravel 12 and Filament 4, featuring multi-panel architecture for administrators and property providers, plus public-facing pages (without a Filament panel).

## About Sweet Home

Sweet Home is a modern real estate platform that enables property management and listing creation. The application features two distinct panels:

- **Admin Panel**: Complete system management including user administration, master data, property approval workflow, and blog management
- **Provider Panel**: Property provider interface for managing company profiles, creating and editing property listings with interactive maps

## Tech Stack

- **Backend**: Laravel 12.40
- **Admin UI**: Filament 4.2
- **Frontend**: Livewire 3.7, Tailwind CSS 4.1
- **Database**: SQLite (development), PostgreSQL/MySQL (production ready)
- **Storage**: MinIO/S3 compatible storage for documents and images
- **Maps**: Leaflet integration with Filament Map Picker (dotswan/filament-map-picker)
- **Testing**: Pest 4.1
- **PHP**: 8.3.27

## Features

### Admin Panel (`/admin`)

- **User Management**: Manage users and roles (admin/provider)
- **Master Data**: Locations (cities, regions, postal codes), categories, and property characteristics
- **Property Approval**: Review, approve, or reject property listings with notes
- **Blog Management**: Create and publish blog posts with rich content
- **Contact Submissions**: View all property inquiries system-wide

### Provider Panel (`/provider`)

- **Company Profile**: Manage company information, services, and contact details
- **Property Management**: 
  - Create and edit property listings
  - Interactive map picker for location selection
  - Upload property images with thumbnail selection
  - Attach property documents
  - Manage property characteristics
  - View submission status and rejection notes
- **Inquiries**: View contact submissions for own properties

### Public Pages (no panel)

- **Home Page** (`/`): Overview, featured properties, and CTA for providers
- **Property Listing** (`/properties`): Browse and filter approved properties
- **Property Detail** (`/properties/{slug}`): Full details, image gallery, read-only map, and contact submission form
- **Agent Info**: Provider/company profile info shown on property detail
- **Blog Listing** (`/blog`): List of published blog posts
- **Blog Detail** (`/blog/{slug}`): Read a full article

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Credits

Built with:
- [Laravel](https://laravel.com)
- [Filament](https://filamentphp.com)
- [Livewire](https://livewire.laravel.com)
- [Tailwind CSS](https://tailwindcss.com)
