# docs/conf.py

import os
import sys
import datetime

# Add current directory to sys.path
sys.path.insert(0, os.path.abspath('..'))

# -- Project information -----------------------------------------------------

project = 'dotenv'
author = 'lazervel'
copyright = f'{datetime.datetime.now().year}, {author}'
release = '1.0.0'

# -- General configuration ---------------------------------------------------

extensions = [
    'myst_parser',  # enables Markdown parsing
]

# Only support markdown
source_suffix = {
    '.md': 'markdown',
}

# Set README.md as the main doc
master_doc = 'README'

# -- Options for HTML output -------------------------------------------------

html_theme = 'sphinx_rtd_theme'

# -- GitHub integration (optional) -------------------------------------------

html_context = {
    'display_github': True,
    'github_user': 'lazervel',
    'github_repo': 'dotenv',
    'github_version': 'main',
    'conf_py_path': '/docs/',
}

# -- Other configs -----------------------------------------------------------

exclude_patterns = ['_build', 'Thumbs.db', '.DS_Store']
