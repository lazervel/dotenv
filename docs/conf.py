# docs/conf.py

import os
import sys
import datetime

# Add root path
sys.path.insert(0, os.path.abspath('..'))

# -- Project info ------------------------------------------------------------

project = 'dotenv'
author = 'lazervel'
copyright = f'{datetime.datetime.now().year}, {author}'
release = '1.0.0'

# -- General configuration ---------------------------------------------------

extensions = ['myst_parser']

# Support Markdown
source_suffix = {
    '.md': 'markdown',
}

# Use README.md as the root document
master_doc = 'README'

# -- HTML output -------------------------------------------------------------

html_theme = 'sphinx_rtd_theme'

# Optional: GitHub integration
html_context = {
    'display_github': True,
    'github_user': 'lazervel',
    'github_repo': 'dotenv',
    'github_version': 'main',
    'conf_py_path': '/docs/',
}

# -- Other -------------------------------------------------------------------

exclude_patterns = ['_build', 'Thumbs.db', '.DS_Store']
