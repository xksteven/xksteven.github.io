---
layout: post
title:  "Vibe Coding Tips"
date:   2025-05-07 12:00:00
categories: vibe coding AI ML LLM vibe-coding
published: true
---

## Some random tidbits

Here are a few random tidbits I've found useful when doing vibe coding.  

Note: This was mostly tested and tried with claude-code (I've had quite a bit of fun using it for some projects).

* Do not have very long files.  Try to keep it under 1K lines
* Try to have tests or things that can fail at compile time
    * This lets you have the LLM debug the input/output directly by running the code itself
* Commit frequently (but commit yourself).  
    * I find that letting the model commit will inevitably commit "bad" code.  You want to be able to revert back to a last known good state
* Make sure you "know" what you want.  This can also be rough sketch of it.
    * The model may go off and implement an easier thing instead of what you want
* Models tend to write code and not delete code.
    * Ask it to delete or update the README every so often
    * Ask it to summarize code parts and update inline docs (on "complex" function calls is my suggestion).
    * Be careful as it might write too many inline docs and then the file gets too big.
* Try to keep everything locally.  
    * Examples of this is tailwindcss (basically inlines the CSS per line)
    * This allows the model to look at things nearby and have almost all the info it needs.
* I think it's actually okay to repeat code (especially if it's not "important"). 
* Use more than one model. 
    * If claude-code gets stuck jump in yourself or ask Google gemini-2.5-pro (my alternative favorite for copying long inputs and asking questions)

Where I think it still sucks:
* Video game development
    * Almost all of the tools either write weird states 
    * or rely on the GUI implicitly or explicitly.
    * How to fix this? Make a mostly text based video game library/engine
* Any newer frameworks.  
    * I tried it with Tauri 2 and it would write half of the things correctly for Tauri 2.  The other half the time default to Tauri 1
* Integration with Cloud providers
    * I almost always have to look stuff up.  Even Google's gemini gets things wrong for supporting google cloud.
