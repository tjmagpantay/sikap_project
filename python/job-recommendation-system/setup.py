from setuptools import setup, find_packages

setup(
    name='job-recommendation-system',
    version='0.1.0',
    author='Your Name',
    author_email='your.email@example.com',
    description='A job recommendation system that matches jobseekers with job postings based on skills.',
    packages=find_packages(where='src'),
    package_dir={'': 'src'},
    install_requires=[
        'Flask',  # or 'FastAPI'
        'scikit-learn',
        'pdfplumber',
        'PyPDF2',
        'pandas',  # Optional: for data manipulation
        'numpy',   # Optional: for numerical operations
    ],
    classifiers=[
        'Programming Language :: Python :: 3',
        'License :: OSI Approved :: MIT License',
        'Operating System :: OS Independent',
    ],
    python_requires='>=3.6',
)