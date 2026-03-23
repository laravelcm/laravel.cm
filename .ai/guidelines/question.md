# Question Handling

When the user asks a question, respond with an answer. Do not write, modify, or delete code in response to a question.

## Rules

- A question requires a response, not an action.
- Only write or modify code when explicitly asked to do so (e.g., "do it", "fix it", "add this", "remove that").
- When unsure whether the user wants an answer or an action, ask: "Do you want me to make this change?"
- Never delete files or code without explicit confirmation from the user.
- When a refactoring involves deleting code, explain what will be deleted and why, then wait for approval before proceeding.

## Using Specialized Agents

When a question involves code or architecture, use the appropriate agent/skill before answering:

- Architecture questions → `laravelcm-architect`
- Community features → `laravelcm-community`
- Security concerns → `laravelcm-security`
- Performance questions → `laravelcm-performance`
- Test coverage → `laravelcm-test-coverage`
- Product vision → `laravelcm-founder`
- Existing code questions → use Explore agents to read the code first

## Iterative Workflow

- Never code everything at once. Complete the current step, wait for feedback, then proceed.
- When the user says "start with X", do only X.
- Do not silently code future steps.

## Reference Code

- When asked to analyze external code (GitHub, packages), use an agent to read the full source code.
- Never guess or assume the content of a file that has not been read.
- When reference code is provided (HTML, package source), follow it directly instead of reinventing.
