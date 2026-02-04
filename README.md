# Laravel Library Catalog (Books + Articles)

This repository is a **starter Laravel project layout** for managing books and articles, including:

- Importing **MARC** records for books (authors, subjects, publishers, etc.).
- Importing **RIS / EndNote (ENW)** records for articles.
- Attaching files (PDFs, scans, datasets) to books or articles.
- A search-friendly data model (ready for Laravel Scout / Meilisearch / Elasticsearch).

> This repo is a lightweight scaffold intended to be installed into a fresh Laravel app.
> You can copy the files into a new Laravel project (`laravel new library-catalog`) or
> extend this repository into a full app by running `composer create-project` and moving
> the files into place.

## Quick Start

1. Create a new Laravel application:
   ```bash
   composer create-project laravel/laravel library-catalog
   ```
2. Copy this repo's `app/`, `database/`, `routes/`, and `config/` into the new app.
3. Run migrations:
   ```bash
   php artisan migrate
   ```
4. Configure storage for attachments:
   ```bash
   php artisan storage:link
   ```
5. Configure search:
   - `config/search.php` includes recommended drivers.
   - For Meilisearch: `composer require laravel/scout meilisearch/meilisearch-php`

## Importers

- **MARCImporter**: Ingests MARC records, extracts authors/subjects/publishers, and links them.
- **RISImporter**: Ingests RIS/ENW records for articles, with field mapping to taxonomy.

These services are stubbed with clear extension points for real parsing libraries.

## Data Model

- **Books**: title, ISBN, publication date, publisher, authors, subjects.
- **Articles**: title, journal, DOI, publication date, authors, subjects.
- **Attachments**: polymorphic relationship (book or article) with file metadata.
- **Taxonomies**: authors, subjects, publishers stored as shared models.

## Search

The `SearchIndexable` trait in `app/Models/Concerns` is a placeholder for Laravel Scout.
The `SearchService` provides a single entry point to index or query.

---

If you want this to be a fully wired Laravel app (controllers, UI, API), I can extend the scaffold.
