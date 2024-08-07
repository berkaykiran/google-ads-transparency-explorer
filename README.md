## Plandex
- Install Plandex
```bash
curl -sL https://plandex.ai/install.sh | bash
```
- Define OpenAI API key from .env file
```bash
source .env
export OPENAI_API_KEY=$OPENAI_API_KEY
```
- Create a new project
```bash
plandex new
```
- Load the directory layout (file names only)
```bash
plandex load src --tree
```
- Load a directory recursively with all the files
```bash
plandex load src -r 
```