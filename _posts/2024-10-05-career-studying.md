---
layout: post
title:  "Daily Study notes"
date:   2024-09-29 12:00:00
categories: Career Studying ML Probability leetcode System design
published: false
---


Reading through probability and Statistics for Engineering and the Sciences

Chapter 1 notes


### Reviewing ML

I do recommend the 3blue1 brown series for deep learning as starting point for deep learning:

https://www.youtube.com/playlist?list=PLZHQObOWTQDNU6R1_67000Dx_ZCJB-3pi

Embedding matrix -> Maps word to vectors

Attention -> maps tokens + positions to 

##### Single head attention computation

Where E is the embedding vector
Query vector
W_Q @ E_x = Q_x
Key vector
W_K @ E_x = K_x

For each x,y where x,y are number of embeddings
K_x \dot Q_y
Better written though as 
QK^T

softmax (QK^T)   Over the "columns"

Value vector
W_V @ E_x = V_x

Attention final form = 
softmax(QK^T)V

Really though that produces the attention "difference" or update vector so it becomes

E + softmax(QK^T)V

##### Multihead Attention

For multi head we repeat the above but instead its

(where d is delta and # represents the head number)
softmax(QK^T)V = dE_1
softmax(QK^T)V = dE_2
...

Final form is:

E + sum_i dE_i


##### Self attention vs cross attention

cross attention is "attention" but computed from two distinct domains such as language translation
In cross attention the Key and Query maps act on the different datasets


## System design

I recommend going through this: https://github.com/donnemartin/system-design-primer?tab=readme-ov-file#system-design-topics-start-here






