import './bootstrap'
import { printPage } from './print'

import.meta.glob(['../images/**'])

window.printPage = printPage
