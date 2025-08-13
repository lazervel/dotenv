# conf.py for Sphinx + Read the Docs

import os
import sys
import datetime

# Add current directory to sys.path
sys.path.insert(0, os.path.abspath('.'))

# -- Project information -----------------------------------------------------

project = 'dotenv'
author = 'lazervel'
copyright = f'{datetime.datetime.now().year}, {author}'
release = '1.0.0'  # You can sync this with your repo release

# -- General configuration ---------------------------------------------------

extensions = [
    'myst_parser',           # for Markdown support
]

# Source file types
source_suffix = {
    '.rst': 'restructuredtext',
    '.md': 'markdown',
}

# The master toctree document.
master_doc = 'index'

# -- Options for HTML output -------------------------------------------------

html_theme = 'sphinx_rtd_theme'

# -- GitHub integration ------------------------------------------------------

html_context = {
    'display_github': True,
    'github_user': 'lazervel',
    'github_repo': 'dotenv',
    'github_version': 'main',
    'conf_py_path': '/docs/',
}

# -- Misc --------------------------------------------------------------------

exclude_patterns = ['_build', 'Thumbs.db', '.DS_Store']
