# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this repo is

A static, dependency-free website for the course **"Inteligência Artificial Aplicada ao Ciclo de Desenvolvimento de Software"** (TRF1). There is no build system, package manager, bundler, linter, or test suite — the entire site is plain HTML/CSS/JS files opened directly in a browser or served as static assets. Content is in Brazilian Portuguese, for a public-sector (Judiciário) audience.

## Commands

There is nothing to install or build. To preview a page, open the `.html` file directly in a browser, or serve the repo root with any static file server (e.g. `python -m http.server`) so relative links between `index.html` and `aula-N/` resolve correctly. There is no lint or test command — verify changes by opening the page and checking it visually/functionally in a browser.

## Structure

- `index.html` — the course landing page. It renders lesson cards from two plain JS arrays, `aulas` (numbered lessons 1–10) and `aulasExtras` (supplementary lessons), via a `criarCard()` function. **Adding a new lesson requires two steps: creating the lesson HTML file, and adding an entry for it in the matching array in `index.html`** — otherwise it's unreachable from the site.
- `aula-N/` — one folder per numbered lesson, each holding one self-contained `.html` lesson file (occasionally more than one, e.g. `aula-3`). Filenames are not consistently patterned (`Aula_N_Titulo.html` vs `AulaNN_...html`) — check the folder before assuming a name.
- `aula-extra/`, `aula-extra1/` — supplementary lessons outside the main numbered sequence, following the same self-contained HTML format.
- Lesson folders (mostly `aula-4` through `aula-8`) also contain instructor-facing material that is **not** part of the rendered site: `solucoes.md`, `desafio.md`, `desafio-solucao-instrutor.md`, `roteiro-instrutor.md`, `roteiro-aluno.md`, `checklist-instrutor.md`, `faq.md`, `prompts.md`, etc. These are informal prose Markdown, read by the instructor preparing class, not linked from any HTML.
- `aula-N/codigo/` (present in `aula-4` through `aula-8`) is a **static teaching snapshot** of a toy PHP/MySQL CRUD app ("SISPROT" — a fictional protocol-tracking system) used as the running example across those lessons: `index.php`, `protocolo_form.php`, `conexao.php`, `encerrar.php`, `estilo.css`, `schema.sql`. It's identical/near-identical across lesson folders (it's a copied snapshot, not meant to be executed here) and exists purely as reference code shown/discussed in the corresponding lesson's HTML.
- `aula-8/codigo/rag-exemplo/` is the one exception with real runnable material: a Colab notebook and a Streamlit app (Python) demonstrating RAG over PDFs, with its own `README.md` and `requirements.txt`.
- Image assets live in per-lesson `imagens/` or `images/` folders (naming varies), referenced by relative path from that lesson's HTML.

## Do not confuse this repo's "SISPROT" with the real project

The `codigo/` snapshots and screenshots in this repo are teaching material only. **The real SISPROT application is a separate project the user hand-codes at `C:\xampp2\htdocs\protocolo` — never edit that path.** Everything in this repo (`c:\trf1\curso`) — including the `aula-N/codigo` snapshots — is fair game to edit; it's course content, not the production system.

## Lesson page architecture (the important part)

Every lesson `.html` file is **fully self-contained**: all CSS lives in a `<style>` block in `<head>`, all JS in a `<script>` block at the end of `<body>`. There is no shared stylesheet or shared JS file anywhere in the repo (only Google Fonts is loaded externally). New lessons are built by copying an existing lesson file as a starting template and editing its content in place — not by extracting shared components.

Despite each file being independent, they all reuse the **same design system and CSS class vocabulary**, defined via CSS custom properties (`--ink`, `--paper`, `--surface`, `--gold`, `--teal`, etc.) and a consistent set of component classes:

- `.hero`, `.topbar`, `#progress` — page header and a scroll-progress bar (JS-driven).
- `.module-divider` — full-width section divider marking a new "Etapa" (stage) within a lesson.
- `.concept-box`, `.insight-box`, `.callout` — boxed content for definitions, tips, and warnings, respectively.
- `.instruction-step` — a numbered step within a hands-on exercise.
- `.value-table` / `.value-table-wrapper` — data tables.
- `.checklist` — checkmark list, typically used as an end-of-step verification list.
- `.promptbox` — dark, monospace block for a literal prompt meant to be copied into an AI tool.
- `.agenda-list` — the vertical timeline-style list used in each lesson's "what we'll cover" intro section.
- `.shot-grid` / `.shot-figure` — grid of captioned screenshots.
- `.quiz-*` classes + a `verificarSequencia(inputId, expectedSequence, gabaritoId, msgId)` JS helper — an inline self-check quiz pattern (student types a short answer sequence to reveal an answer key), defined per-file where used (see `aula-7`, `aula-8`).

Every lesson also ends with the same boilerplate `<script>`: a scroll-based progress bar updater and an `IntersectionObserver` that adds an `.in` class to `.reveal` elements as they scroll into view.

When adding or editing a lesson, match this existing class vocabulary and structure rather than introducing new patterns, unless the content genuinely doesn't fit anything existing.

## Content conventions

- All lesson content is written in pt-BR, addressed to a public-sector audience.
- A recurring theme across lessons is a "golden rule": never paste real or sensitive citizen/case data into an external AI tool — examples throughout the course use fictitious names, protocol numbers, and dates.
- When a lesson cites laws, regulations, or external tools/products, verify current details (via web search) rather than relying on prior knowledge — this course is actively maintained against a moving target (in-progress legislation, fast-changing AI tooling) and has previously needed corrections/updates to legal citations and tool descriptions as they changed.
