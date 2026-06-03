const { spawn } = require('child_process');
spawn('php', ['-S', '0.0.0.0:' + process.env.PORT, '-t', 'public'], { stdio: 'inherit' });
import { spawn } from 'child_process';
spawn('php', ['-S', '0.0.0.0:' + process.env.PORT, '-t', 'public'], { stdio: 'inherit' });
