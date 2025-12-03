---
applyTo: '**'
---
Real Estate Platform with Admin, Provider & Public Panels
Goal: Build a Laravel 10 + Filament 4 app with three panels:

Admin Panel: Manage users, master data (locations, categories, characteristics), approve listings, manage blogs, view submissions.
Provider Panel: Manage company profile, create/edit listings (with map, docs, images), view own submissions.
Ads/Search Panel (Public): Custom Filament panel (or pages) accessible without login. Displays property listings (search/filter), property details (with map & contact form), and blog posts.
Proposed Changes
Database & Models
users: role enum (admin, provider). Profile columns: company_name, description, address, services, phone, website, avatar (path to profile picture).
properties:
id, user_id, title, slug, address (text), description, price, size, rooms
location_id (FK), category_id (FK)
status enum (draft,pending,approved,rejected)
rejection_notes (text, nullable) - Admin notes when rejecting a listing
condition, property_type, availability, living_area, cubic_area, plot_size, construction_year, immocode, property_number
document (path), latitude, longitude
property_characteristics (master): id, name, type, options.
property_images: property_id, path, is_thumbnail.
locations (master): id, city, region, country, postal_code.
contact_submissions: property_id, firstname, lastname, address, postcode, email, phone, message, created_at.
blog_posts: id, title, slug, content (rich text), published_at, user_id (author), timestamps.
Storage
MinIO S3 for property-documents, property-images, and blog images.
Filament Panels & Resources
1. Admin Panel (/admin)
UserResource: Manage users & roles.
LocationResource: Master locations (City, Region, Country, Zip).
CategoryResource, PropertyCharacteristicResource: Master data.
PropertyResource: View all properties with Approve/Reject actions.
Relation Managers:
ImagesRelationManager: Manage property images (view, add, delete, set thumbnail).
CharacteristicsRelationManager: Manage property characteristics (attach/detach).
SubmissionsRelationManager: View contact submissions for this property.
BlogPostResource: Create/edit/publish blog content.
ContactSubmissionResource: View all inquiries (global view).
2. Provider Panel (/provider)
Registration: Custom page for sign-up with company profile.
Profile: Edit company details.
PropertyResource: Create/edit own listings.
Form: Slug (auto), Address, Leaflet Map (picks lat/lng), Master Location (select), Images, Single Document, Specs, Characteristics.
ContactSubmissionResource: View inquiries for own properties.
3. Ads/Search Panel (Public) (/ or /search)
Type: A separate Filament Panel (or custom pages) configured with no auth middleware.
Pages:
Home/Search: Grid of approved properties with filters (Location, Price, Rooms, etc.). Includes CTA button to register as a provider.
Property Detail: Full info, Leaflet Map (read-only), Contact Form (public submission).
Blog List: Grid of published posts. Includes CTA button to register as a provider.
Blog Detail: Read full article. Includes CTA button to register as a provider.
Styling: Can use Filament's default or custom Blade views with Tailwind/FluxUI components.
Workflows
Provider registers → fills profile → creates property (draft) → submits (pending).
Admin reviews property → Approves (status approved) or Rejects with notes (status rejected, rejection_notes filled).
Provider can view rejection notes and resubmit after fixing issues.
Admin writes blog posts → publishes.
Public User visits Ads Panel → searches properties → views detail → submits contact form.
Public User reads blog posts.
Verification Plan
Automated Tests:
ProviderCanCreatePropertyTest (full flow with map/docs).
AdminCanApprovePropertyTest.
PublicCanViewListingsTest (ensure approved only).
PublicCanSubmitContactFormTest.
AdminCanManageBlogTest.
Manual Tests:
Verify map picker in Provider panel vs read-only map in Public panel.
Verify S3 uploads for docs/images.
Check blog visibility on public site.
Notes

Map: Leaflet via filament-leaflet-map (or custom component).
S3: MinIO configuration in 
.env
.
Public Access: Ensure the Ads Panel has auth middleware disabled or is a standalone set of public routes/pages.

Table name conventions and relationships should follow Laravel standards.

Implement soft deletes where appropriate (e.g., properties, blog posts).

Property relation managers include image uploads,  characteristic attachments, contact submissions.