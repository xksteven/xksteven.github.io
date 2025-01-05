---
layout: post
title:  "Daily Study notes"
date:   2024-09-29 12:00:00
categories: Career Studying ML Probability leetcode System design
published: false
---


My notes as I apply to places




## Meta

Recruiter phone screen
mostly a pulse check (as I like to call it)

Meeting with the hiring manager
I showed up late partly due to my own misunderstanding


## Synth Bee

Recruiter phone screen at Oct 21st
Just got funded Wednesday of last week

Addy is the COO
    will go over what they're building
Michael software engineering manager
Rony then thats it

She's a 1099 contractor.  
Addy is from Boston consulting group
West coast is more relaxed

### Interview with

Oct 24th Meeting with PM or COO Adi
playing point on the process
cofounder

Rony Abobout 2x unicorn founder mako 
bought by striker

Magic Leap 
One of the investors did a hostile takeover
hired Pegi Johnson
Joined BSG as

Boston consulting group

hard core private quity 
tomo bravo
own kupa anaplan vertical saas companies
operating arm for tomo bravo

BCG X digital ventures go to fortune 500 companies and take ideas from 0 to 1
Ryder do trucks and logistics

use iot to build preventable 
took it 300 million dollar business

do digital transformation
Different use cases across the 


Rony and Adi met in 2020
AI blockchain and sustainability
Quantiuum
industry solutions 

How do you like the CEO gig and want to come in as COO
Fortune 50 company
raised the first round 20 million dollar round
VP software systems ex Amazon
did PhD under Yoshua Bengio
10 people

ex CEO and CPOs
building the avengers team


Meet the VP of software
Connect with him Michael runningwolf

AI in its current form is dangerous unknown
Try to build something with a slightly different architecture and determinism
spoke to 100 CEOs 
what will it take for you to adopt AI

Crreate something else
Enough enterprises 
99.9% might not be enough

safe knowability oversight
build computing intelligence

share backgrounds
1 STAR question
1 "leetcode"

### Interview Q

Ex Amazon

where do I fail?
What did I learn?
How did the project turn out?

```
"""
huge log files
different links that a user clicks on
billion user

time sorted log file
unique url and time stamp

find the most common 3 paid 


Assume it's all sitting in memroy

Need userid too

time stamp , user id, page visit
"""

# links from page to page
# It'll be stored in a dict where each page lists all of the users who visited that page

class Trie():
#   todo do init function 
	page = ""
  page_next = None # This can be a dict of options that point to more Tries
  counter = 0

# timestamp, userid, page as string
logfile = [[12324, 123, "amazon.com"],]
page_seqs = Trie()
users = {}
for entry in logfile:
    # I'll assume a 30 min timeout per session
    time, user_id, page = entry
    if user_id not in users:
      users[user_id] = [time, [page]]
    else:
      
      last_time, last_page = users[user_id]
#       We're assuming new session if it's old
      if time - last_time > 30*60:
    
#       update old session of the user
    	else:	
        old_pages = users[user_id][1]
        users[user_id] = [time, old_pages + [page]]


for user in users:
  	page_sequence = user[1]
    tmp = page_seqs # current head of the trie which we reset each time
    for page in page_sequence:
      # What I want -> page_seq[page] {1, next_page}
      
#         want to increment the count
        tmp.page_next[page].counter += 1
#   			want to point to next page
				tmp = tmp.page_next[page]
#   Make a new Trie each time
#  setting the actual pages
# sort the Trie based on the counter
# return top X sequences 

```

1 server 1 node how to best handle inference on it.


XR and AI

hear back next week 

Didn't get it.

