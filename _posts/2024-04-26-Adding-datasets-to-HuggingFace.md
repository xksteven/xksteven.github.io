---
layout: post
title:  "Adding datasets to huggingface"
date:   2024-04-25 12:00:00
categories: huggingface git ML
published: true
---

# How to add datasets to huggingface

This mostly chronicles me adding in [xksteven/dialogue_nli](https://huggingface.co/datasets/xksteven/dialogue_nli) to huggingface.  I never found the docs intuitive how huggingface itself was essentially a git platform but by having a different UI I had difficulty finding the link to even download to begin.

## Add an ssh key to huggingface

You will need to add an ssh key to huggingface to be able to upload files via git.

```
ssh-keygen -t ed25519 -C "your.email@example.co"
ssh-add ~/.ssh/id_ed25519
```

Then add your public key i.e. `~/.ssh/id_ed25519.pub` to your [ssh user settings](https://huggingface.co/settings/keys)

## Make a new dataset in huggingface

Make a hugginface profile (if you don't already have one).
Click on the top right and click New Dataset give it a name and select the license.

## Change remote to be able to git push

Go to the dataset card and you should be able to run

```
git clone https://huggingface.co/datasets/xksteven/dialogue_nli
#git remote set-url origin git@hf.co:<repo_path>
git remote set-url origin git@hf.co:datasets/xksteven/dialogue_nli
```

For updating a huggingface org.  You'll need to create an access token instead of an SSH key.

```
git remote set-url origin https://user_name:<access_token>@huggingface.co/<repo_path>
```

`repo_path` is of the form 

- <user_name>/<repo_name> for models
- datasets/<user_name>/<repo_name> for datasets
- spaces/<user_name>/<repo_name> for Spaces

For adding large files (anything bigger than 5MB) you'll need to install git-lfs. Then add them like so:

```
git lfs track dnli/dialogue_nli/dialogue_nli_train.jsonl
# or like 
# git lfs track *.ogg
```

## Testing

Try loading your dataset.

```
from datasets import load_dataset

# Path to your local dataset directory
dataset = load_dataset('xksteven/dialogue_nli', split='train')
print(dataset)
```

If it fails to be automatically processed you will probably need to add a dataset file.

Here's a [template](https://github.com/huggingface/datasets/blob/d69d1c654c4645a0474731794a20d4c012d2d214/templates/new_dataset_script.py)

test it out locally with 

```
from datasets import load_dataset

# Path to your local dataset directory
dataset = load_dataset('/path/to/local/dir', split='train')
print(dataset)
```

Note that all of the names must match. i.e. the dataset name on huggingface is `dialogue_nli` so the python loader file must be called `dialogue_nli.py`.